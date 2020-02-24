<?php
namespace mod\member\providers;

/**
 * 会员持有币种相关业务逻辑
 */

use app\http\exception\Error;
use mod\member\model\Trades as Model;
// use mod\common\traits\BaseProviders;

class Trades
{
    // 引入公共库
    // use BaseProviders;

    /**
     * @var Model
     */
    protected $model;

    // 指定验证器
    // protected $validate = null;

    // 验证不过能跳出异常
    // protected $failException = true;

    /**
     * 配置模块别名映射表
     * @var array
     */
    // protected static $app_map = [];

    /**
     * Coins constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    public function add($data) {
        return $this->model->add($data);
    }
    public function getOne($condition) {
        return $this->model->orderOrDef('id desc')->getOnly($condition);
    }
    public function getLists($condition) {
        $field = 'id, coin_id, nums, coin_unit, unit_price, coin_price, act, exchange_id, create_time';
        return $this->model->getListForPage($condition, 15, $field, 'id desc');
    }
    public function getList($condition) {
        $field = 'id, coin_id, nums, coin_unit, unit_price, coin_price, act, exchange_id, create_time';
        return $this->model->getList($condition, false, $field, 'create_time asc, id asc');
    }
    public function sellCoin($member_id, $coin_id, $sell_number) {
        $trade_list = $this->model->where('member_id', $member_id)->where('coin_id', $coin_id)->where('act', 1)->where('is_sell', 0)->order('create_time asc')->select();
        if( ! $trade_list) {
            throw new Error('系统异常');
        }
        $act_costs = 0;
        foreach ($trade_list as $trade) {
            $no_sell = $trade['nums'] - $trade['sell_nums'];
            if($no_sell < $sell_number) {
                $act_costs += $trade['coin_price'] * $no_sell;
                $update = [
                    'sell_nums' => $trade['nums'],
                    'is_sell' => 1,
                ];
                $this->model->where('id', $trade['id'])->update($update);
                $sell_number -= $no_sell;
            } else {
                $act_costs += $trade['coin_price'] * $sell_number;
                $update = [
                    'sell_nums' => $sell_number,
                ];
                if($no_sell == $sell_number) {
                    $update['is_sell'] = 1;
                }
                $this->model->where('id', $trade['id'])->update($update);
                break;
            }
        }
        return $act_costs;
    }
    // 计算单币收益数据
    public function calcCoinIncome($coin_id) {
        // 计算当前币种的价值
        // 获取当前币种的钱包信息

    }
    // 计算总收益率
    public function calcIncomeRate() {

    }
    // 计算累积收益
    public function calcAccumulateIncome() {

    }
    // 计算持有收益
    public function calcHavingIncome() {

    }
    // 计算卖出收益
    public function calcSellIncome() {

    }
    public function calcXirr() {
        $list = array(
            ['stringTime'=>'2019-01-01','payment'=>-100.00],
            ['stringTime'=>'2019-09-15','payment'=>70.00],
            ['stringTime'=>'2020-01-01','payment'=>120.00]
        );
        $xirr = $this->getXirr($list);
        return $xirr;
    }
    function getXirr($cashflows){
        if ( empty($cashflows) ) return 0;
        $years = [];
        $first_time = strtotime($cashflows[0]['stringTime']);

        foreach ($cashflows as $v){
            $years[] = (strtotime($v['stringTime'])-$first_time)/86400/365;
        }
        $residual = 1.0;
        $step = 0.05;
        $guess = 0.05;
        $epsilon = 0.0001;
        $limit = 10000;
        $count=0;
        while (abs($residual)>$epsilon&&$limit > 0){
            $limit--;
            $residual=0.0;
            foreach ($cashflows as $i=>$trans){
                ((float)pow($guess, $years[$i])==0)?:$residual += $trans['payment'] / pow($guess, $years[$i]);
            }
            if(abs($residual)>$epsilon){
                if($residual>0){
                    $guess+=$step;
                }else{
                    $guess-=$step;
                    $step/=2.0;
                }
            }
            $count++;
            if($count>1000)break;
        }
        return number_format(100*($guess-1),2);
    }
}
