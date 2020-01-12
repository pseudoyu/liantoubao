<?php
namespace app\member\providers;
/**
 * 登陆凭证生成
 * @author Lazy 2019-04-22
 */
use extend\facade\JWT;

class Token {
    /**
     * 根据当前用户信息生成token
     * @author Lazy 2019-04-22
     * @param \app\member\model\User $user 指定的用户数据
     * @param array                  $token_data 其它相关的数据
     * @return string
     */
    public static function make($user, array $token_data = []) {
        return [
            'mobile'           => hide_mobile($user->mobile),
            'nick'             => $user->nick,
            'avatar'           => $user->avatar ?: self::initAvatar($user->auth_id, $user->role_id),
            'auth_id'          => $user->auth_id,
            'auth_status'      => $user->auth_status,
            'auth_status_text' => $user->auth_status_text,
            'viper'            => $user->viper,
            'invalid_time'     => $user->invalid_time,
            'overdue_time'     => $_SERVER['REQUEST_TIME'] + 86399,
            'token'            => self::encrypt($user, $token_data)
        ];
    }
    /**
     * 生成token密文
     * @author Lazy
     */
    protected static function encrypt($user, $token_data) {
        $data = array_merge(['uid' => $user->id], $token_data);
        return JWT::encode($data)->getToken();
    }
//    /**
//     * 初始化头像
//     * @author Lazy 2019-01-17
//     * @param int $role_id 对应的身份ID
//     * @param int $role_id 对应的角色ID
//     * @return string
//     */
//    protected static function initAvatar($auth_id, $role_id) {
//        if($auth_id == 10){
//            return '//resource.aibanzhuan.cn/material/' . ($role_id == 2 ? 'person' : 'team') . '.jpg';
//        } else {
//            return '//resource.aibanzhuan.cn/material/company.jpg';
//        }
//        return '//resource.aibanzhuan.cn/material/default.jpg';
//    }
}