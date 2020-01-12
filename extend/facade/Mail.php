<?php
namespace extend\facade;

use think\Facade;
/**
 * @see \extend\notice\Mail
 * @mixin \extend\notice\Mail
 * @method bool send(string|array $mail, string $subject, string|array $content, string $tpl_id = '') static 发送邮件
 * @method void getCode() static 获取错误代码
 * @method void getMessage() static 获取错误信息
 */
class Mail extends Facade {
    protected static function getFacadeClass() {
        return 'extend\notice\Mail';
    }
}