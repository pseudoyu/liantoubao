<?php

namespace extend\notice;

use PHPMailer\PHPMailer\PHPMailer;
use think\facade\Log;

class Mail
{
    // 相关配置
    private static $config;
    // PHPMailer 对象
    private static $client;
    // 收件地址
    private $mail_address;
    //错误代码
    private $code;
    //错误信息
    private $message;
    //模板目录
    const TPL = __DIR__ . '/templete/';
    /**
     * 获取错误代码
     * @author Lazy
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }
    /**
     * 获取错误信息
     * @author Lazy
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }
    /**
     * 发送邮件
     * @author Lazy 2018-09-20
     * @param string|array $mail    邮件收件地址，多个可用数组或者 , 隔开
     * @param string       $subject 邮件主题
     * @param string|array $content 邮件内容，使用模板时传入参数数据
     * @param string       $tpl_id  邮件模板,未指定模板时直接发送文本邮件
     * @return bool
     */
    public function send($mail, $subject, $content, $tpl_id = '') {
        return $this->getClient()
                    ->setAddress($mail)
                    ->setSubject($subject)
                    ->setContent($content, $tpl_id)
                    ->_send();
    }
    /**
     * 实例化 PHPMailer 对象
     * @author Lazy 2018-09-20
     * @return PHPMailer
     */
    protected function getClient() {
        if(is_null(static::$client)){
            $this->loadConfig();
            static::$client = new PHPMailer();
            //设置SMTP参数
            static::$client->IsSMTP();
            static::$client->IsHTML(true);
            //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            static::$client->CharSet = 'UTF-8';
            //启用 SMTP 验证功能
            static::$client->SMTPAuth = true;
            //设置发送通道
            if (static::$config['ssl'] == 'ssl') {
                static::$client->SMTPSecure = 'ssl';
            }
            //设置SMTP服务
            static::$client->Host     = static::$config['server']; //SMTP服务器地址
            static::$client->Username = static::$config['user'];   //SMTP用户名
            static::$client->Password = static::$config['passwd']; //SMTP密码
            static::$client->Port     = static::$config['port'];   //SMTP端口
            static::$client->From     = static::$config['email'];  //发件人EMAIL
            static::$client->FromName = static::$config['nickname'];//发件人名称
        }
        return $this;
    }
    /**
     * 设置邮件接收地址
     * @author Lazy 2018-09-20
     * @param string $mail 接邮件地址
     * @return $this
     */
    protected function setAddress($mail) {
        $this->mail_address = $mail;
        return $this;
    }
    /**
     * 设置邮件主题内容
     * @author Lazy 2018-09-20
     * @param string $subject 主题内容
     * @return $this
     */
    protected function setSubject($subject) {
        static::$client->Subject = $subject;
        return $this;
    }
    /**
     * 设置邮件内容
     * @author Lazy 2018-09-20
     * @param string $content 邮件内容
     * @return $this
     */
    protected function setContent($content, $tpl_id = '') {
        if ( ! empty($tpl_id)) {
            if (is_array($content)) {
                $content['subject'] = static::$client->Subject;
            } else {
                $content = [
                    'subject' => static::$client->Subject,
                    'content' => $content
                ];
            }
            $content = app('view')->fetch(self::TPL . $tpl_id . '.html', $content);
        }
        static::$client->Body = $content;
        return $this;
    }
    /**
     * 发送邮件
     * @author Lazy 2018-09-20
     * @return mixed
     */
    protected function _send() {
        static::$client->AddAddress($this->mail_address);
        $state = static::$client->send() ? true : false;
        if ( ! $state) {
            $this->code    = 'error';
            $this->message = static::$client->ErrorInfo;
            //记录错误日志
            $this->writeLog();
        } else {
            $this->code = $this->message = 'ok';
        }
        return $state;
    }
    /**
     * 读取配置
     * @author Lazy 2018-09-20
     */
    protected function loadConfig() {
        if(is_null(static::$config))
            static::$config = config('email.');
    }
    /**
     * 记录错误日志
     * @author Lazy 2018-09-20
     * @param $data 日志内容
     */
    protected function writeLog() {
        $data = [
            'code'    => $this->code,
            'message' => $this->message,
        ];
        Log::record("Send Email Error:\n【Code】:{code}\n【Message】:{message}", 'email', $data);
    }
}
