<?php
namespace app\index\controller;

use app\http\exception\Error;
use mod\member\providers\Follow;
use mod\member\providers\Trades;
use mod\money\providers\Money;
use think\facade\Cache;
use think\Request;
use mod\member\providers\Coins as MemberCoins;
use mod\member\providers\Trades as Provider;
use mod\admin\providers\Common;
use function GuzzleHttp\Psr7\str;

class Trade {
    protected $provider;
    public function __construct(Provider $trades) {
        $this->provider = $trades;
    }
    /**
     * 新增交易
     * @return \think\Response
     */
    public function add(Request $request) {
        $data = [
            'coin_id'  => $request->coin_id,
            'nums' => $request->nums,
            'coin_unit' => $request->coin_unit,
            'unit_price' => $request->unit_price,
            'act'  => $request->act,
            'exchange_id'  => $request->exchange_id,
            'create_time' => $request->create_time,
            'member_id' => $request->uid,
        ];
        $validate = new \app\index\validate\Trade();
        if (!$validate->check($data)) {
            return wrong($validate->getError());
        }
        if($data['coin_unit'] == 'USD') {
            $data['coin_price'] = $data['unit_price'];
        } else {
            $trans = app(Money::class)->quotes();
            if( ! array_key_exists($data['coin_unit'], $trans)) {
                return wrong('汇率系统异常');
            }
            // 执行汇率转换
            $data['coin_price'] = $data['unit_price'] / $trans[$data['coin_unit']];
        }
        $data['create_time'] = strtotime($data['create_time']);
        if($data['create_time'] > time()) {
            return wrong('交易时间异常');
        }
        // 计算币种余额
        $member_coin = $this->provider->getOne(['member_id' => $request->uid, 'coin_id'  => $request->coin_id]);
        if( ! $member_coin) {
            if($request->act == 1) {
                $data['residue'] = $request->nums;
            } else {
                return wrong('当前币种余量不足');
            }
        } else {
            if($request->act == 1) {
                $data['residue'] = $member_coin['residue'] + $request->nums;
            } else {
                $data['residue'] = $member_coin['residue'] - $request->nums;
                if($data['residue'] < 0) {
                    return wrong('当前币种余量不足');
                }
            }
        }
        // 写入统计表
        $coin_result = app(MemberCoins::class)->update($data);
        return $this->provider->add($data)
            ? complete('添加成功') : wrong('添加失败');
    }

    /**
     * 交易详情
     * @param Request $request
     * @return \Response
     */
    public function info(Request $request) {
        $id = $request->id;
        if( ! $id) {
            return wrong('参数错误');
        }
        $info = $this->provider->getOne(['id' => $request->id, 'member_id' => $request->uid]);
        if( ! $info) {
            return wrong('未检索到信息');
        }
        return output($info);
    }

    /**
     * 交易列表
     * @param Request $request
     * @return \Response
     */
    public function lists(Request $request) {
        $condition = [
            'member_id' => $request->uid,
        ];
        if($request->coin_id > 0) {
            $condition['coin_id'] = $request->coin_id;
        }
        if($request->acts > 0) {
            $condition['act'] = $request->acts;
        }
        if($request->time_mode > 0) {
            if($request->time_mode == 1) {
                $start_time = strtotime($request->start_time);
                $end_time = strtotime("+1 month",$start_time);
            }
            if($request->time_mode == 2) {
                $start_time = $request->start_time ? strtotime($request->start_time) : 0;
                $end_time = $request->end_time ? strtotime($request->end_time) + 86400 : time();
            }
            $condition['create_time'] = [
                'start_time' => $start_time,
                'end_time' => $end_time,
            ];
        }
        $info = $this->provider->getLists($condition);
        return output($info);
    }
    public function coin_trade_list(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        $condition = [
            'member_id' => $request->uid,
            'coin_id' => $request->coin_id,
            'create_time' => [
                'start_time' => time() - 60 * 60 * 6,
                'end_time' => time(),
            ]
        ];
        $info = $this->provider->getList($condition);
        return output($info);
    }
    public function update_limit(Request $request) {
        if( ! $request->coin_id || $request->loss_limit > 100) {
            return wrong('参数错误');
        }
        $coin_price_array = app(\mod\coins\providers\Index::class)->getPrice();
        if( ! array_key_exists($request->coin_id, $coin_price_array)) {
            return wrong('币价接口异常');
        }

        $coin_price = $coin_price_array[$request->coin_id];

        $member_coin_info = app(MemberCoins::class)->findOne($request->uid,$request->coin_id);
        if( ! $member_coin_info) {
            $insert_coin_info = [
                'member_id' => $request->uid,
                'coin_id' => $request->coin_id,
                'act' => 1,
                'nums' => 0,
                'coin_price' => 0,
            ];
            app(MemberCoins::class)->update($insert_coin_info);
            $member_coin_info = [
                'profit_limit' => 0,
                'loss_limit' => 0,
                'sms' => 0,
            ];
        }
        $coin_limit_cache = Cache::get('coin_limit_'.$request->coin_id);
        dump($coin_limit_cache);
        if( ! $coin_limit_cache) {
            $coin_limit_cache = [
                'profit' => [],
                'loss' => [],
            ];
        }
        $profit_limit = $request->profit_limit ? sprintf("%.5f",(1 + ($request->profit_limit / 100)) * $coin_price) : 0;
        // 清除原有缓存
        if( $coin_limit_cache['profit'] && $member_coin_info['profit_limit'] > 0 &&  $member_coin_info['sms'] == 0) {
            if( array_key_exists(sprintf("%.5f",$member_coin_info['profit_limit']), $coin_limit_cache['profit'])) {
                foreach ($coin_limit_cache['profit'][sprintf("%.5f",$member_coin_info['profit_limit'])] as $k => $v) {
                    if($v == $request->uid) {
                        unset($coin_limit_cache['profit'][sprintf("%.5f",$member_coin_info['profit_limit'])][$k]);
                    }
                }
                // 重置数组起始值
                $coin_limit_cache['profit'][sprintf("%.5f",$member_coin_info['profit_limit'])] = array_values($coin_limit_cache['profit'][sprintf("%.5f",$member_coin_info['profit_limit'])]);
            }
            //$coin_limit_cache['profit'][$profit_limit] = array_merge(array_diff($coin_limit_cache['profit'][$profit_limit], [$request->uid]));
        }
        // 新增缓存
        if(array_key_exists($profit_limit,$coin_limit_cache['profit'])) {
            $coin_limit_cache['profit'][$profit_limit][] = $request->uid;
        } else {
            $coin_limit_cache['profit'][$profit_limit] = [$request->uid];
        }
        $loss_limit = $request->loss_limit ? sprintf("%.5f",(1 - ($request->loss_limit / 100) ) * $coin_price) : 0;
        // 清除原有缓存
        if( $coin_limit_cache['loss'] && $member_coin_info['loss_limit'] > 0 &&  $member_coin_info['sms'] == 0) {
            if (array_key_exists(sprintf("%.5f",$member_coin_info['loss_limit']), $coin_limit_cache['loss'])) {
                foreach ($coin_limit_cache['loss'][sprintf("%.5f",$member_coin_info['loss_limit'])] as $k => $v) {
                    if ($v == $request->uid) {
                        unset($coin_limit_cache['loss'][sprintf("%.5f",$member_coin_info['loss_limit'])][$k]);
                    }
                }
                // 重置数组起始值
                $coin_limit_cache['loss'][sprintf("%.5f",$member_coin_info['loss_limit'])] = array_values($coin_limit_cache['loss'][sprintf("%.5f",$member_coin_info['loss_limit'])]);
            }
        }
        // 新增缓存
        if(array_key_exists($loss_limit,$coin_limit_cache['loss'])) {
            $coin_limit_cache['loss'][$loss_limit][] = $request->uid;
        } else {
            $coin_limit_cache['loss'][$loss_limit] = [$request->uid];
        }
        Cache::set('coin_limit_'.$request->coin_id, $coin_limit_cache);
        // 更新数据库
        $data = [
            'profit_limit' => $profit_limit,
            'loss_limit' => $loss_limit,
            'sms' => 0,
        ];
        return app(MemberCoins::class)->update_limit($request->uid,$request->coin_id,$data) ? complete('更新成功') : wrong('更新失败');;
    }
    public function coin_count(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        return output(app(MemberCoins::class)->findOne($request->uid,$request->coin_id));
    }
    public function calc_xirr() {
        return output($this->provider->calcXirr());
    }
    // 计算单币收益数据
    public function single_coin_info(Request $request) {
        $coin_id = $request->coin_id;
        if( ! $coin_id) {
            return wrong('参数错误');
        }
        // 获取当前币种的钱包信息
        $coin_info = app(MemberCoins::class)->findOne($request->uid,$coin_id);
        if ( ! $coin_info) {
            return wrong('暂无数据');
        }
        $coin_info = self::calc_coin_rate($coin_info);
        return output($coin_info);
    }
    private function calc_coin_rate($coin_info) {
        $coin_price_array = app(\mod\coins\providers\Index::class)->getPrice();
        $coin_price = $coin_price_array[$coin_info['coin_id']];
        if(! $coin_price) {
            throw new Error('数据接口异常');
        }
        $price = $coin_price * $coin_info['nums'];
        $income_rate = ( $price - $coin_info['costs'] + $coin_info['sell_income'] ) / $coin_info['costs'];
        $coin_info['coin_price'] = $coin_price;
        $coin_info['price'] = $price;
        $coin_info['having_income'] = $price - $coin_info['costs'];
        $coin_info['income_rate'] = $income_rate;
        return $coin_info;
    }
    private function calc_coin_price($coin_info) {
        $coin_price_array = app(\mod\coins\providers\Index::class)->getPrice();
        $coin_price = $coin_price_array[$coin_info['coin_id']];
        if(! $coin_price) {
            throw new Error('数据接口异常');
        }
        $price = $coin_price * $coin_info['nums'];
        return $price;
    }
    public function rank_cache() {
        $coins = app(MemberCoins::class)->allCoin();
        // 按用户组装数据
        $member_coins = [];
        if( ! $coins) {
            return [];
        }
        foreach ($coins as $coin) {
            $member_coins[$coin['member_id']][] = $coin;

        }
        // 获取所有用户信息
        $user_lists = app(\mod\member\providers\Index::class)->getAll();
        if ( ! $user_lists) {
            return [];
        }
        $users = [];
        foreach ($user_lists as $user) {
            $users[$user['id']] = [
                'avatar' => $user['avatar'],
                'nick' => $user['nick'],
            ];
        }
        $rate_array = [];
        foreach ($member_coins as $key => $v) {
            $income_tmp = self::calc_all_income($v);
            $rate_array[$key] = [
                'member_id' => $income_tmp['member_id'],
                'coin_ids' => $income_tmp['coin_ids'],
                'rate' => $income_tmp['rate'],
            ];
        }
        array_multisort(array_column($rate_array,'rate'),SORT_DESC,$rate_array);
        // 重置Key
        $data = [
            'count' => count($rate_array),
            'data' => [],
        ];

        foreach ($rate_array as $k => $rate) {
            $rate['rank'] = $k + 1;
            $rate['user_info'] = $users[$rate['member_id']];
            $data['data'][$rate['member_id']] = $rate;
        }
        //$member_coins
        Cache::set('coin_rank', $data);
        return $data;
    }
    public function top_rank() {
        $rank = Cache::get('coin_rank');
        if( ! $rank) {
            $rank = self::rank_cache();
        }
        if( ! $rank) {
            return wrong('排行榜数据异常');
        }
        $list = array_slice($rank['data'],0,20);
        return output($list);
    }
    public function follow_user_info(Request $request) {
        $member_id = $request->member_id;
        if( ! $member_id) {
            return wrong('参数错误');
        }
        $is_follow = app(Follow::class)->is_follow($request->uid,$member_id);
        if( ! $is_follow) {
            return wrong('无权限查看');
        }
        $rank = Cache::get('coin_rank');
        if( ! $rank) {
            $rank = self::rank_cache();
        }
        if( ! $rank) {
            return wrong('排行榜数据异常');
        }
        if( ! array_key_exists($member_id, $rank['data'])) {
            return wrong('暂无用户数据');
        }
        return output($rank['data'][$member_id]);
    }
    private function calc_all_income($data) {
        $sell = 0;
        $total_price = 0;
        $costs = 0;
        $act_costs = 0;
        $coin_ids = [];
        foreach ($data as $coin) {
            $coin_ids[] = $coin['coin_id'];
            $total_price += self::calc_coin_price($coin);
            $sell += $coin['sell_income'];
            $costs +=  $coin['costs'];
            $act_costs += $coin['act_costs'];
        }

        $having = $total_price - $costs;
        //原有持有收益率算法
        // $rate = ( $having + $sell ) / $costs;
        // 202002因客户需求变更 更新收益率算法
        $rate = $act_costs ? $total_price / $act_costs : 0;
        $return = [
            'member_id' => $data[0]['member_id'],
            'having' => $having,
            'sell' => $sell,
            'costs' => $costs,
            'act_costs' => $act_costs,
            'total_income' => $having + $sell,
            'total_price' => $total_price,
            'coin_ids' => implode(',',$coin_ids),
            'rate' => $rate,
        ];
        return $return;
    }
    public function my_income(Request $request) {
        $coin_info = app(MemberCoins::class)->findByUid($request->uid);
        if( ! $coin_info) {
            return output([]);
        }
        $data = self::calc_all_income($coin_info);
        // 计算个人排名
        $rank = Cache::get('coin_rank');
        $data['rank'] = 0;
        if ($rank && array_key_exists($request->uid, $rank['data'])) {
            $my_rank = $rank['data'][$request->uid];
            $data['rank'] = ( 1 - ($my_rank['rank'] - 1) / ( $rank['count'] - 1 )) * 100;
        }
        return output($data);
    }
    public function my_coin(Request $request) {
        $member_id = $request->member_id ? $request->member_id : $request->uid;
        if($member_id != $request->uid) {
            // 检查是否关注
            $is_follow = app(Follow::class)->is_follow($request->uid,$member_id);
            if( ! $is_follow) {
                return wrong('无权限查看');
            }
        }
        $my_coin = [];
        $coin_info = app(MemberCoins::class)->findByUid($member_id);
        if( $coin_info) {
            foreach ($coin_info as $coin) {
                $my_coin[] = self::calc_coin_rate($coin);
            }
        }
        return output($my_coin);
    }
    public function has_coin_percent(Request $request) {
        $member_id = $request->member_id ? $request->member_id : $request->uid;
        if($member_id != $request->uid) {
            // 检查是否关注
            $is_follow = app(Follow::class)->is_follow($request->uid,$member_id);
            if( ! $is_follow) {
                return wrong('无权限查看');
            }
        }
        $coin_percent = [];
        $coin_info = app(MemberCoins::class)->findByUid($member_id);
        $total_price = 0;
        if( $coin_info) {
            $coin_percent['rate'] = self::calc_all_income($coin_info)['rate'];
            foreach ($coin_info as &$coin) {
                $price_tmp = self::calc_coin_price($coin);
                $total_price += $price_tmp;
                $coin['price'] = $price_tmp;
            }
            foreach ($coin_info as $coin) {
                $coin_percent['data'][] = [
                    'coin_id' => $coin['coin_id'],
                    'member_id' => $coin['member_id'],
                    'percent' => $coin['price'] / $total_price,
                ];
            }
        }
        return output($coin_percent);
    }
    public function my_income_time(Request $request) {
        $time_array = ['month', 'season', 'half', 'year'];
        $time = $request->search_time;
        if( ! $time || ! in_array($time, $time_array)) {
            return wrong('参数错误');
        }
        if($time == 'month') {
            $start_time = date('Y-m');
        }
        if($time == 'season') {
            $month = (ceil(date('m') / 3) - 1) * 3 + 1;
            $start_time = date('Y-'.$month);
        }
        if($time == 'half') {
            $month = (ceil(date('m') / 6) - 1) * 6 + 1;
            $start_time = date('Y-'.$month);
        }
        if($time == 'year') {
            $start_time = date('Y-1');
        }
        $start = strtotime($start_time);
        // 读取所有交易
        $trade_list = $this->provider->getList(['member_id', $request->uid]);
        if( ! $trade_list) {
            return output([]);
        }
        $trade_calc = [];
        // 初始化持币数组
        $has_coin = [];
        foreach ($trade_list as $trade) {
            //发生在统计日前的交易
            if($trade['create_time'] < $start || $trade['create_time'] == $start) {
                // 统计币种剩余数量
                if($trade['act'] == 1) {
                    if(array_key_exists($trade['coin_id'], $has_coin)) {
                        $has_coin[$trade['coin_id']] += $trade['nums'];
                    } else {
                        $has_coin[$trade['coin_id']] = $trade['nums'];
                    }
                } else {
                    if(array_key_exists($trade['coin_id'], $has_coin)) {
                        $has_coin[$trade['coin_id']] -= $trade['nums'];
                    } else {
                        $has_coin[$trade['coin_id']] = 0 - $trade['nums'];
                    }
                }
            } else {
                // 需要进行基金净值法计算的数据
                $trade_calc[] = $trade;
            }
        }
        //初始化资金
        $init_income = 0;
        // 计算统计日初始资金
        if( $has_coin) {
            $coin_price_array = app(\mod\coins\providers\Index::class)->getTimerPrice($start);
            foreach ($has_coin as $init_coin_id => $init_coin_num) {
                if($init_coin_num == 0) {
                    unset($has_coin[$init_coin_id]);
                }
                if($init_coin_num < 0) {
                    return wrong('数据异常');
                }
                if(! array_key_exists($init_coin_id, $coin_price_array)) {
                    return wrong('历史币价查询异常');
                }
                // 计入统计
                $init_income += $init_coin_num * $coin_price_array[$init_coin_id];
            }
        }
        // 初始化净值
        $init_net_value = 1;
        // 初始化持有数量
        $init_number = $init_income;
        foreach ($trade_calc as $t_c){
            //如果出现中途卖空或之前未发生交易的情况
            $trade_price_array = app(\mod\coins\providers\Index::class)->getTimerPrice($t_c['create_time']);
            if($init_income == 0) {
                // 之前未持有币，第一笔交易是删减，报错
                if($t_c['act'] == 2) {
                    return wrong('交易系统错误-101');
                }
                if(! array_key_exists($t_c['coin_id'], $trade_price_array)) {
                    return wrong('历史币价查询异常');
                }
                $init_income = $t_c['nums'] * $trade_price_array[$t_c['coin_id']];
                $init_number = $init_income;
                $has_coin = [
                    $t_c['coin_id'] => $t_c['nums'],
                ];
                $init_net_value = 1;
            } else {
                // 计算发生交易前的货币总价值
                foreach ($has_coin as $c_id => $c_num) {
                    if(! array_key_exists($c_id, $trade_price_array)) {
                        return wrong('历史币价查询异常');
                    }
                    // 计入统计
                    $init_income += $c_num * $trade_price_array[$c_id];
                }
                // 计算发生交易前的货币净值
                $init_net_value = $init_income / $init_number;
                // 计算发生交易后的持币数量
                if($t_c['act'] == 1) {
                    if(array_key_exists($t_c['coin_id'], $has_coin)) {
                        $has_coin[$t_c['coin_id']] += $t_c['nums'];
                    } else {
                        $has_coin[$t_c['coin_id']] = $t_c['nums'];
                    }
                } else {
                    if(array_key_exists($t_c['coin_id'], $has_coin)) {
                        $has_coin[$t_c['coin_id']] -= $t_c['nums'];
                        if($has_coin[$t_c['coin_id']] < 0) {
                            return wrong('交易系统错误-102');
                        }
                    } else {
                        return wrong('交易系统错误-103');
                    }
                }
                // 计算发生交易后的货币总价值
                foreach ($has_coin as $c_id => $c_num) {
                    if(! array_key_exists($c_id, $trade_price_array)) {
                        return wrong('历史币价查询异常');
                    }
                    // 计入统计
                    $init_income += $c_num * $trade_price_array[$c_id];
                }
                // 计算发生交易后的持有数量
                $init_number = $init_income / $init_net_value;
            }
        }
        // 获取现有币种现价
        $coin_price_now = app(\mod\coins\providers\Index::class)->getPrice();
        foreach ($has_coin as $c_id => $c_num) {
            if(! array_key_exists($c_id, $coin_price_now)) {
                return wrong('历史币价查询异常');
            }
            // 计入统计
            $init_income += $c_num * $coin_price_now[$c_id];
        }
        // 计算当前净值
        $init_net_value = $init_income / $init_number;
        // 计算持有收益
        $rate = $init_net_value - 1;
        return output($rate);
    }
}
