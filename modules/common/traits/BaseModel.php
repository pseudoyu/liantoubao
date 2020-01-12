<?php
namespace mod\common\traits;
/**
 * 公用模型,实现基础通用的增删改查功能
 * @author Lazy 2018-10-11
 */
use think\exception\ClassNotFoundException;

trait BaseModel {
    protected $require_field = [];
    /**
     * Query 实例化对象
     * @var \think\DB\Query
     */
    protected $formatInstance;
    /**
     * 读取数据,指定返回数据量
     * @author Lazy 2018-09-27
     * @param array  $search 列表检索条件
     * @param int    $limit  获取数量,false 返回全部
     * @param string $field  返回数据的字段列表
     * @param string $order  数据排序规则
     * @return think\Collection
     */
    public function getList(array $search, $limit = 30, $field = null, $order = null) {
        return $this->searchOrDef($search)
                    ->fieldOrDef($field)
                    ->orderOrDef($order)
                    ->limit($limit)
                    ->select();
    }
    /**
     * 获取列表 - 带分页
     * @author Lazy 2018-09-27
     * @param array  $search   列表检索条件
     * @param int    $limit    每页条数
     * @param string $field    返回数据的字段列表
     * @param string $order    数据排序规则
     * @param string $var_page 默认分页参数名称
     * @return think\Collection
     */
    public function getListForPage(array $search = [], $limit = 15, $field = null, $order = null, $var_page = 'page') {
        return $this->searchOrDef($search)
                    ->fieldOrDef($field)
                    ->orderOrDef($order)
                    ->paginate($limit, false, compact('var_page'));
    }
    /**
     * 获取单条信息
     * @author Lazy 2018-09-27
     * @param array        $search 信息检索条件
     * @param string|array $field  需要返回的数据字段
     * @return null|\think\model\Collection
     */
    public function getOnly(array $search, $field = null) {
        return $this->searchOrDef($search)
                    ->fieldOrDef($field)
                    ->find();
    }
    /**
     * 根据条件返回数据统计
     * @author Lazy 2018-09-27
     * @param array  $search 统计条件
     * @param string $group  统计分组字段
     * @return int|\think\model\Collection
     */
    public function getCount(array $search, $group = null) {
        $this->searchOrDef($search);
        if(is_null($group)){
            return (int) $this->count();
        } else {
            $stats = $this->field($group . ',count(*) as tp_count')
                          ->group($group)->select();
            return $stats->isEmpty() ? [] : array_column($stats->toArray(), 'tp_count', $group);
        }
    }
    /**
     * 写入数据
     * @access public
     * @param  array      $data  数据数组
     * @param  array|true $field 允许字段
     * @param  bool       $replace 使用Replace
     * @return static
     */
    public function add($data = [], $field = null, $replace = false) {
        $model = new static();

        if ( ! empty($this->require_field))
            $model->setRequire($this->require_field);

        if ( ! empty($field))
            $model->allowField($field);

        $model->isUpdate(false)->replace($replace)->save($data, []);
        return $model;
    }
    /**
     * 更新数据
     * @access public
     * @param  array      $data  数据数组
     * @param  array      $where 更新条件
     * @param  array|true $field 允许字段
     * @return static
     */
    public function modify(array $condition = [], $data = [], $field = null) {
        $model = new static();

        if ( ! empty($this->require_field))
            $model->setRequire($this->require_field);

        if ( ! empty($field))
            $model->allowField($field);

        $condition = array_merge($this->require_field, $condition);
        $model->isUpdate(true)->save($data, $condition);

        return $model;
    }
    /**
     * 删除数据
     * @author Lazy 2018-09-26
     * @param array $search 删除条件
     * @return bool
     */
    public function del(array $search) {
        $this->searchOrDef($search);
        $query = $this->formatInstance;
        $this->formatInstance = null;
        return $query->delete();
    }
    /**
     * 获取查询必要条件
     * @author Lazy 2018-10-11
     * @param array $field
     */
    public function getRequire($field = '') {
        $field = is_string($field) ? str_array($field) : $field;
        if (is_string($field)) {
            return $field === '' ? $this->require_field
                : (isset($this->require_field[$field]) ? $this->require_field[$field] : null);
        } else {
            return intersect_key($this->require_field, $field);
        }
    }
    /**
     * 设置查询必要条件
     * @author Lazy 2018-10-11
     * @param array $field
     */
    public function setRequire(array $field) {
        $this->require_field = array_merge($this->require_field, $field);
        return true;
    }
    /**
     * 获取当前模型的数据库查询对象
     * @author Lazy 2018-11-26
     * @return \think\DB\Query
     */
    protected function formatDB() {
        if (is_null($this->formatInstance))
            $this->formatInstance = $this->db(false);
        return $this->formatInstance;
    }
    /**
     * 处理数据列表的检索条件
     * @author Lazy 2018-09-28
     * @param array  $condition 组装检索条件
     * @param string $prefix    字段前缀标识
     * @return $this
     */
    public function searchOrDef($condition, $prefix = '') {
        //过滤空条件
        $condition = array_filter($condition, function ($val) {
            return ! empty($val) || strlen($val) || is_bool($val);
        });
        $condition = array_merge($this->require_field, $condition);
        if (empty($condition))
            return $this;
        $field = array_keys($condition);
        $this->formatDB()->withSearch($field, $condition, $prefix);
        return $this;
    }
    /**
     * 指定查询字段 支持字段排除和指定数据表
     * @author Lazy 2018-09-27
     * @param  mixed   $field
     * @param  boolean $except    是否排除
     * @param  string  $tableName 数据表名
     * @param  string  $prefix    字段前缀
     * @param  string  $alias     别名前缀
     * @return $this
     */
    public function fieldOrDef($field, $except = false, $tableName = '', $prefix = '', $alias = '') {
        $field = empty($field) ? (isset($this->_field) && $this->_field ? $this->_field : '*') : $field;
        $this->formatDB()->field($field, $except, $tableName, $prefix, $alias);
        return $this;
    }
    /**
     * 指定排序 order('id','desc') 或者 order(['id'=>'desc','create_time'=>'desc'])
     * @author Lazy 2018-09-27
     * @param  string|array $field 排序字段
     * @param  string       $order 排序
     * @return $this
     */
    public function orderOrDef($field, $order = null) {
        if (empty($field)) {
            $field = isset($this->_order) && $this->_order ? $this->_order : '';
            $order = null;
        }
        if ( ! empty($field))
            $this->formatDB()->order($field, $order);
        return $this;
    }
    /**
     * 根据模型别名映射关系表加载对应的模块
     * @author Lazy 2018-12-05
     * @param string $alias 模型别名
     * @return mixed
     * @throws ClassNotFoundException
     */
    protected function app($alias) {
        if ( ! isset(static::$app_map))
            throw new ClassNotFoundException('Model map not configured!', __CLASS__);
        if ( ! isset(static::$app_map[$alias]))
            throw new ClassNotFoundException($alias . ' not found!', __CLASS__);
        if (is_string(static::$app_map[$alias]))
            static::$app_map[$alias] = app(static::$app_map[$alias]);
        return static::$app_map[$alias];
    }

    public function __call($method, $args) {
        if ('withattr' == strtolower($method)) {
            return call_user_func_array([$this, 'withAttribute'], $args);
        }
        if ( is_null($this->formatInstance)) {
            return call_user_func_array([$this->db(), $method], $args);
        } else {
            $query = call_user_func_array([$this->formatInstance, $method], $args);
            $this->formatInstance = null;
            return $query;
        }
    }
    /**
     * 处理检索必要条件,处理用户ID
     * @author Lazy 2018-10-11
     * @param \think\db\Query $query
     * @param int             $value 用户ID值
     * @param array           $data  其它表单数据
     */
    public function searchUidAttr($query, $value, $data) {
        $query->where(['uid' => $value]);
    }
    /**
     * 处理检索必要条件,处理主键ID
     * @author Lazy 2018-10-15
     * @param \think\db\Query $query
     * @param int             $value 用户ID值
     * @param array           $data  其它表单数据
     */
    public function searchIdAttr($query, $value, $data) {
        $query->where(['id' => $value]);
    }
    /**
     * 处理检索必要条件,处理父键ID
     * @author Lazy 2018-10-15
     * @param \think\db\Query $query
     * @param int             $value 用户ID值
     * @param array           $data  其它表单数据
     */
    public function searchPidAttr($query, $value, $data) {
        if ( ! empty($value) || $value === 0)
            $query->where(['pid' => $value]);
    }
    /**
     * 处理关键词检索 - 样例 具体实现请在调用的本类中实现
     * @author Lazy 2018-10-11
     * @param \think\db\Query $query
     * @param string          $keyword 关键词
     * @param array           $data    其它表单数据
     */
    //public function searchKeyWordsAttr($query, $keyword, $data) {
    //    if ( ! empty($keyword)) {
    //        $op = '';
    //        if (false !== stripos($keyword, ' ')) {
    //            $op    = 'OR';
    //            $keyword = array_map(function ($val) {
    //                return '%' . $val . '%';
    //            }, explode(' ', $keyword));
    //        } else {
    //            $keyword = '%' . $keyword . '%';
    //        }
    //        $query->where($this->_search_keywords ?: 'title', 'like', $keyword, $op);
    //    }
    //}
    /**
     * 处理时间范围 - 样例 具体实现请在调用的本类中实现
     * @author Lazy 2018-10-11
     * @param \think\db\Query $query
     * @param string          $time 关键词
     * @param array           $data 其它表单数据
     */
    //public function searchTimeBetweenAttr($query, $time, $data) {
    //    if ( ! empty($time) && is_array($time)) {
    //        if (count($time) == 2) {
    //            list($start, $end) = $value;
    //            $start = empty($start) ? 0 : strtotime($start);
    //            $end   = empty($end) ? 0 : strtotime($end);
    //        } else {
    //            $start = $time[0] ? strtotime($time[0]) : 0;
    //            $end   = 0;
    //        }
    //        if ($start && $end) {
    //            $query->whereBetween($this->_search_time_between ?: 'update_time', [$start, $end + 86309]);
    //        } elseif ($start) {
    //            $query->where($this->_search_time_between ?: 'update_time', '>' ,$start - 1);
    //        } elseif ($end) {
    //            $query->where($this->_search_time_between ?: 'update_time', '<' ,$start + 86309);
    //        }
    //    }
    //}
}