<?php
namespace mod\member\providers;

/**
 * 会员持有币种相关业务逻辑
 */

use app\http\exception\Error;
use mod\member\model\Coins as Model;
// use mod\common\traits\BaseProviders;

class Coins
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
    /**
     * 统计所有用户持有资产统计
     */
    public function property() {
        return $this->model->field('coin_id,sum(nums) as sum_nums, sum(costs) as sum_costs')
                           ->group('coin_id')
                           ->select();
    }
    public function allCoin() {
        return $this->model->field('*')
            ->group('coin_id')
            ->select();
    }
    public function findOne($member_id, $coin_id) {
        return $this->model->getOnly(['member_id' => $member_id, 'coin_id' => $coin_id]);
    }
    public function  findByUid($member_id) {
        return $this->model->where(['member_id' => $member_id])->select();
    }
    public function update($data) {
        // 检查是否存在
        $coin_info = $this->model->getOnly(['member_id' => $data['member_id'], 'coin_id' => $data['coin_id']]);
        if ( ! $coin_info) {
            if($data['act'] == 2) {
                throw new Error('数据异常');
            }
            $insert_info = [
                'member_id' => $data['member_id'],
                'coin_id' => $data['coin_id'],
                'nums' => $data['nums'],
                'costs' => $data['coin_price'] * $data['nums'],
                'act_costs' => $data['coin_price'] * $data['nums'],
                'buy_number' => $data['nums'],
                'sell_number' => 0,
                'sell_income' => 0,
            ];
            return $this->model->add($insert_info);
        }
        if($data['act'] == 1) {
            $modify_info = [
                'nums' => $coin_info['nums'] + $data['nums'],
                'costs' => $coin_info['costs'] + $data['coin_price'] * $data['nums'],
                'act_costs' => $coin_info['act_costs'] + $data['coin_price'] * $data['nums'],
                'buy_number' => $coin_info['buy_number'] + $data['nums'],
            ];
        } else {
            $act_costs = app(Trades::class)->sellCoin($data['member_id'], $data['coin_id'], $data['nums']);
            $modify_info = [
                'nums' => $coin_info['nums'] - $data['nums'],
                'act_costs' => $coin_info['act_costs'] - $act_costs,
                'sell_income' => $coin_info['sell_income'] + $data['coin_price'] * $data['nums'],
                'sell_number' => $coin_info['sell_number'] + $data['nums'],
            ];
            if($modify_info['nums'] < 0) {
                throw new Error('数据错误');
            }
        }
        return $this->model->modify(['id' => $coin_info['id']], $modify_info);
    }
    public function update_limit($member_id, $coin_id, $value) {
        return $this->model->modify(['member_id' => $member_id, 'coin_id' => $coin_id], $value);
    }
}
