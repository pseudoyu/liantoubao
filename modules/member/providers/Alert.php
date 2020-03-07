<?php

namespace mod\member\providers;

use mod\member\model\Alert as Model;
// use mod\common\traits\BaseProviders;

class Alert
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
     * Alert constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    public function findByUid($member_id) {
        return $this->model->where(['member_id' => $member_id, 'sms' => 0])->select();
    }
    public function findUerCoinAlert($member_id, $coin_id) {
        $info = $this->model->where(['member_id' => $member_id, 'coin_id' => $coin_id, 'sms' => 0])->select();
        if( ! $info) {
            return false;
        }
        $data = [
            'profit' => [],
            'loss' => [],
        ];
        foreach ($info as $item) {
            if ($item['alert_type'] == 1) {
                $data['profit'] = $item;
            }
            if ($item['alert_type'] == 2) {
                $data['loss'] = $item;
            }
        }
        return $data;
    }
    public function updateCoinAlert($member_id, $coin_id) {
        return $this->model->modify(['member_id' => $member_id, 'coin_id' => $coin_id, 'sms' => 0], ['sms' => 2]);
    }
    public function updateCoinView($member_id, $coin_id) {
        return $this->model->modify(['member_id' => $member_id, 'coin_id' => $coin_id, 'sms' => 1, 'is_view' => 0], ['is_view' => 1]);
    }
    public function insertAlert($data) {
        return $this->model->insertAll($data);
    }
    public function delAlert($limit_id, $member_id) {
        return $this->model->modify(['id' => $limit_id, 'member_id' => $member_id], ['sms' => 2]);
    }
    public function findAlert($limit_id, $member_id) {
        return $this->model->where(['id' => $limit_id, 'member_id' => $member_id, 'sms' => 0])->find();
    }
}
