<?php
namespace mod\member\providers;

/**
 * 会员持有币种相关业务逻辑
 */
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
        $field = 'id, coin_id, nums, unit_price, act, exchange_id, create_time';
        return $this->model->getListForPage($condition, 15, $field, 'id desc');
    }
    public function getList($condition) {
        $field = 'id, coin_id, nums, unit_price, act, exchange_id, create_time';
        return $this->model->getList($condition, false, $field, 'create_time asc');
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
