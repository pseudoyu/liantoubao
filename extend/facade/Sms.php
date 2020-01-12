<?php
namespace extend\facade;

use think\Facade;
/**
 * @see \extend\notice\Mail
 * @mixin \extend\notice\Mail
 * @method bool send(string|array $mobile, string $tpl_id,array $data = []) static 发送短信
 * @method void getCode() static 获取错误代码
 * @method void getMessage() static 获取错误信息
 * @method void getBizId() static 获取回执ID
 * @method void getRequestId() static 获取请求ID
 */
class Sms extends Facade {
    protected static function getFacadeClass() {
        return 'extend\notice\Sms';
    }
}