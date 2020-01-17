<?php
namespace app\index\controller;

use app\http\exception\Error;
use mod\member\providers\Follow;
use mod\member\providers\Trades;
use think\facade\Cache;
use think\Request;
use mod\member\providers\Coins as MemberCoins;
use mod\member\providers\Trades as Provider;
use mod\admin\providers\Common;
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
        $info = $this->provider->getLists($condition);
        return output($info);
    }
    public function update_limit(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        $data = [
            'profit_limit' => $request->profit_limit ? $request->profit_limit : 0,
            'loss_limit' => $request->loss_limit ? $request->loss_limit : 0,
            'sms' => $request->sms ? $request->sms : 0,
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
    private function calc_all_income($data) {
        $sell = 0;
        $total_price = 0;
        $costs = 0;
        $coin_ids = [];
        foreach ($data as $coin) {
            $coin_ids[] = $coin['coin_id'];
            $total_price += self::calc_coin_price($coin);
            $sell += $coin['sell_income'];
            $costs +=  $coin['costs'];
        }
        $having = $total_price - $costs;
        $rate = ( $having + $sell ) / $costs;
        $return = [
            'member_id' => $data[0]['member_id'],
            'having' => $having,
            'sell' => $sell,
            'costs' => $costs,
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
        $my_coin = [];
        $coin_info = app(MemberCoins::class)->findByUid($request->uid);
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
}
