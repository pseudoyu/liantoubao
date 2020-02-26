<?php

namespace mod\member\model;

use think\Model;
use mod\common\traits\BaseModel;
use mod\payment\model\Payment;
use mod\member\model\Coins;

class Member extends Model
{
    // 引入公共库
    use BaseModel;

    /**
     * 默认字段
     * @var string|array
     */
    protected $_field = 'id,open_id,nick,avatar,mobile,viper,vip_expire,create_time,coin,permission';

    /**
     * 默认排序规则
     * @var string
     */
    protected $_order = 'id desc';

    // 指定完整的表名
    protected $table = 'jxh_member';

    // 自动时间维护
    // protected $autoWriteTimestamp = true;

    /**
     * 创建时间字段 false表示关闭
     * @var false|string
     */
    // protected $createTime = 'create_time';

    /**
     * 更新时间字段 false表示关闭
     * @var false|string
     */
    // protected $updateTime = 'update_time';
    // 昵称筛选
    public function searchNickAttr($query, $val) {
        $val = trim($val);
        if ( ! empty($val))
            $query->where('nick', 'like', '%' . $val . '%');
    }
    // 手机筛选
    public function searchMobileAttr($query, $val) {
        $val = trim($val);
        if ( ! empty($val)) {
            if (strlen($val) == 11) {
                $query->where('mobile', $val);
            } else {
                if (substr($val, 0, 1) == '1') {
                    $query->where('mobile', 'like', '%' . $val);
                } else {
                    $query->where('mobile', 'like', '%' . $val . '%');
                }
            }
        }
    }
    // 会员状态筛选
    public function searchViperAttr($query, $val) {
        $val = trim($val);
        if ($val) {
            $query->where('viper', '<>', 0);
        } else {
            $query->where('viper', 0);
        }
    }
    // openid筛选
    public function searchOpenIdAttr($query, $val) {
        $query->where('open_id', trim($val));
    }
    // id筛选
    public function searchIdAttr($query, $val) {
        $query->where('id', trim($val));
    }
    // 持有币种列表
    public function coins() {
        return $this->hasMany(Coins::class, 'member_id', 'id');
    }
}
