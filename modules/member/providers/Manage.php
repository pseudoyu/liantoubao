<?php

namespace mod\member\providers;

use app\http\exception\Error;
use mod\member\model\Member as Model;
use mod\common\traits\BaseProviders;

class Manage
{
    // 引入公共库
    use BaseProviders;

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
    protected static $app_map = [
        'stats'   => \mod\member\providers\Stats::class,
        'coins'   => \mod\member\providers\Coins::class,
        'payment' => \mod\payment\providers\Stats::class
    ];

    /**
     * Manage constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // 用户相关统计
    public function dashboard() {
        $member  = $this->app('stats')->length();
        // $payment = $this->app('payment')->income();
        $coins   = $this->app('coins')->property();
        return compact('member', /*'payment', */'coins');
    }
    // 用户列表
    public function getListForPage($args, $limit = 18) {
        $rows = $this->model->getListForPage($args, $limit, 'id,nick,mobile,viper');
        if ( ! $rows->isEmpty())
            $rows->load('coins');
        return $rows;
    }
    // 指定用户的详情信息
    public function find($id) {
        $result = $this->model->find($id);
        if ( ! $result)
            throw new Error('该用户不存在或已被删除', 404);
        $result->append(['coins']);
        return $result;
    }
}
