<?php

namespace mod\payment\providers;

use mod\payment\model\Payment as Model;
// use mod\common\traits\BaseProviders;

class Manage
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
     * Manage constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // 读取指定用户的购买记录
    public function getListByMember($member_id, $limit = 18) {
        return $this->model->getListForPage(compact('member_id'), $limit);
    }
    // 读取全局支付列表
    public function getListForPage($args, $limit = 18) {
        $model = $this->model->alias('p')
                             ->field('p.id,p.member_id,p.title,p.spec,p.nums,p.unit,p.total_fee,p.status,p.end_time,m.nick,m.mobile')
                             ->join('member m', 'm.id=p.member_id');
        // 组装筛选条件
        foreach ($args as $key => $arg) {
            $method = 'search' . parse_name($key, true);
            if (method_exists($this, $method))
                call_user_func_array([$this, $method], [$model, $arg]);
        }
        return $model->paginate($limit, false, ['var_page' => 'page']);
    }
    // 时间范围检索
    protected function searchTimer($query, $val) {
        list($start, $end) = $val;
        if ($start && $end) {
            $query->where('p.end_time', 'between', $val);
        } elseif ($start) {
            $query->where('p.end_time', '>', $start - 1);
        } elseif ($end) {
            $query->where('p.end_time', '<', $end + 1);
        }
    }
    // 昵称检索
    protected function searchNick($query, $val) {
        $val = trim($val);
        if ( ! empty($val))
            $query->where('m.nick', 'like', '%' . $val . '%');
    }
    // 手机号检索
    protected function searchMobile($query, $val) {
        $val = trim($val);
        if ( ! empty($val)) {
            if (strlen($val) == 11) {
                $query->where('m.mobile', $val);
            } else {
                if (substr($val, 0, 1) == '1') {
                    $query->where('m.mobile', 'like', '%' . $val);
                } else {
                    $query->where('m.mobile', 'like', '%' . $val . '%');
                }
            }
        }
    }
}
