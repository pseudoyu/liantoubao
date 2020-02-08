<?php

namespace mod\services\providers;

use app\http\exception\Error;
use mod\services\model\Services as Model;
use mod\services\model\Quoted;
// use mod\common\traits\BaseProviders;

class Manage
{
    // 引入公共库
    // use BaseProviders;

    /**
     * @var Model
     */
    protected $model;

    protected static $field_def = [
        'nums'     => '',
        'price'    => '',
        'discount' => ''
    ];

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
     * Index constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function find($id)
    {
        $data = $this->model->where('id', $id)->find();
        if ( ! $data)
            throw new Error('指定的服务项目不存在');
        // $data->quoted;
        return $data->append(['quoted']);
    }

    public function update($id, $data)
    {
        // 过滤无效数据
        $data = array_filter(array_map(function ($item) use ($id) {
            if ( ! is_array($item))
                return false;
            return $this->formatData($item, $id);
        }, $data));
        // 删除已有的规则数据
        Quoted::where('service_id', $id)->delete();
        if (count($data))
            (new Quoted())->saveAll($data);
        return true;
    }
    /**
     * 验证规则数据是否合法
     * @author Lazy 2020-02-01
     * @param $item
     */
    protected function formatData($item, $id) {
        // 字段过滤
        $item = array_intersect_key(
            array_merge(self::$field_def, $item),
            self::$field_def
        );
        // 验证各个字段数值是还合法
        if ( ! $this->validate($item['nums'])) {
            return false;
        }
        $item['service_id'] = $id;
        $item['price']    = $this->validate($item['price']) ? $item['price'] : 0;
        $item['discount'] = $this->validate($item['discount']) ? $item['discount'] : 0;
        return $item['price'] || $item['discount'] ? $item : false;
    }
    public function validate($val) {
        return $val && is_numeric($val);
    }
}
