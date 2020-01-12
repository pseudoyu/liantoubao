<?php
namespace mod\admin\providers;
/**
 * 公用方法
 * @author Lazy 2019-11-22
 */
class Common {
    // 登陆成功之后使用的session键名
    const SESSION_KEY = 'admin_login_id';
    /**
     * encrypt
     */
    public static function encrypt($passwd, $solt) {
        return md5(md5($passwd) . $solt);
    }
    /**
     * 获取当前登陆用户的信息
     */
    public static function session($key) {
        static $info;
        if ( ! $info)
            $info = session(self::SESSION_KEY);
        return is_null($key) ? $info : ($info[$key] ?: null);
    }
}