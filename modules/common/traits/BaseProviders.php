<?php
namespace mod\common\traits;
/**
 * 公用逻辑,实现基础通用的增删改查功能
 * @author Lazy 2018-10-11
 */
use think\Exception;
use think\exception\ValidateException;
use think\exception\ClassNotFoundException;

trait BaseProviders{
    /**
     * 指定默认验证器
     * @var \think\Validate
     */
    //protected $validate;
    /**
     * 验证失败是否抛出异常
     * @var bool
     */
    //protected $failException = false;
    /**
     * 别名实例缓存
     * @var array
     */
    private static $as_instance = [];
    /**
     * 根据模型别名映射关系表加载对应的模块
     * @author Lazy 2018-12-05
     * @param string $alias 模型别名
     * @return mixed
     * @throws ClassNotFoundException
     */
    protected function app($alias, $args = [], $newInstance = false) {
        if ( ! isset(static::$app_map))
            throw new ClassNotFoundException('Model map not configured!', __CLASS__);
        if ( ! isset(static::$app_map[$alias]))
            throw new ClassNotFoundException($alias . ' not found!', __CLASS__);
        if ($newInstance)
            return app(static::$app_map[$alias], $args, true);
        if ( ! isset(static::$as_instance[$alias]))
            static::$as_instance[$alias] = app(static::$app_map[$alias], $args);
        return static::$as_instance[$alias];
    }
    /**
     * 执行数据验证
     * @author Lazy 2018-10-11
     * @param array           $data     验证数据
     * @param string          $secan    验证场景
     * @param \think\Validate $validate 对应的验证器
     * @throws Exception
     */
    protected function validate($data, $scene = null, $validate = null) {
        if ( ! isset($this->validate) && ! $validate)
            throw new Exception('The validator has not been defined yet');
        //获取验证器
        is_null($validate) && $validate = is_string($this->validate)
            ? $this->validate = app($this->validate) : $this->validate;
        is_string($validate) && $validate = app($validate);
        //设置验证场景
        empty($scene) || $validate->scene($scene);
        //验证数据
        $state = $validate->check($data);
        if ( ! $state) {
            //是否跳出异常
            if (isset($this->failException) && $this->failException)
                throw new ValidateException($validate->getError());
            return $validate;
        }
        return true;
    }
    /**
     * 设置用户UID值
     * @author Lazy 2018-10-11
     * @param int $id 用户ID
     * @return bool
     */
    public function setUid($id) {
        return $this->setRequire('uid', $id);
    }
    /**
     * 设置必须条件
     * @author Lazy 2018-10-11
     * @param string|array $field 条件或条件字段
     * @param string $value 条件值
     */
    public function setRequire($field, $value = null) {
        is_array($field) || $field = [$field => $value];
        return $this->model->setRequire($field);

    }
}