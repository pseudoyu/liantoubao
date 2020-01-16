<?php
namespace app\index\controller;

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
        if($request->act > 0) {
            $condition['act'] = $request->act;
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
    public function update_limit(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        $data = [
            'profit_limit' => $request->profit_limit ? $request->profit_limit : 0,
            'loss_limit' => $request->loss_limit ? $request->loss_limit : 0,
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
}
