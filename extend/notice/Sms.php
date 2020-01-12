<?php
/**
 * 短信发送扩展
 * @author microLazy 2018-09-19
 */
namespace extend\notice;

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use think\facade\Log;
class Sms
{
    //短信API产品名（短信产品名固定，无需修改）
    const PRODUCT = 'Dysmsapi';
    //短信API产品域名（接口地址固定，无需修改）
    const DOMAIN = 'dysmsapi.aliyuncs.com';
    //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
    const REGION = 'cn-hangzhou';
    //短信请求实例
    private static $acsClient;
    //相关配置
    private static $config;
    //请求ID
    private $request_id;
    //错误代码
    private $code;
    //错误信息
    private $message;
    //回执ID
    private $biz_id;
    //短信模板ID
    private $tpl_id = [];

    public function __construct() {
        //加载配置
        $this->loadConfig();
        //加载短信模板
        $tpls = self::$config['sms_tpls'];
        if ( ! empty($tpls))
            $this->tpl_id = $tpls;
    }
    /**
     * 获取请求ID
     * @author Lazy
     * @return mixed
     */
    public function getRequestId() {
        return $this->request_id;
    }
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
    public function getBizId() {
        return $this->biz_id;
    }
    /**
     * 获取回执ID
     * @author Lazy
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }
    /**
     * 发送短信
     * @author Lazy 2018-09-20
     * @param string|array $mobile 短信接收手机号，多个可用一级数组传递
     * @param string       $tpl_id 短信内容模板ID
     * @param array        $data   短信替换内容
     */
    public function send($mobile, $tpl_id, array $data = []) {
        // 非生产模式下只记录发送日志并不真正发送短信
        if (self::$config['debug'])
            return $this->sendLog(array_merge(compact('mobile', 'tpl_id'), $data));
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();
        // 必填，设置短信接收号码
        $request->setphoneNumbers($this->parseMobile($mobile));
        // 必填，设置签名名称
        $request->setSignName(static::$config['sign_name']);
        // 必填，设置模板CODE
        $tpl_id = strtoupper($tpl_id);
        array_key_exists($tpl_id, $this->tpl_id) && $tpl_id = $this->tpl_id[$tpl_id];
        $request->setTemplateCode($tpl_id);
        $request->setTemplateParam($this->parseData($data));
        //发起访问请求
        $acsResponse = $this->getAcsClient()->getAcsResponse($request);
        return $this->parseResult($acsResponse);
    }
    /**
     * 创建短信发送请求实例
     * @author Lazy 2018-09-20
     */
    protected function getAcsClient() {
        if(is_null(static::$acsClient))
            static::$acsClient = new DefaultAcsClient($this->initProFile());
        return static::$acsClient;
    }
    /**
     * 初始化profile
     * @author Lazy 2018-09-20
     */
    protected function initProFile() {
        Config::load();
        $profile = DefaultProfile::getProfile(
            static::REGION,
            static::$config['access_id'],
            static::$config['secret_key']
        );
        $this->addEndpoint();
        return $profile;
    }
    /**
     * 添加通信节点
     * @author Lazy 2018-09-20
     */
    protected function addEndpoint() {
        DefaultProfile::addEndpoint(static::REGION,
            static::REGION,
            static::PRODUCT,
            static::DOMAIN
        );
    }
    /**
     * 读取配置
     * @author Lazy 2018-09-20
     */
    protected function loadConfig() {
        if(is_null(static::$config))
            static::$config = config('sms.');
    }
    /**
     * 当手机号码是数组时，处理成字符串
     * @author Lazy 2018-09-20
     * @param $mobiles 手机号码
     * @return string
     */
    protected function parseMobile($mobiles) {
        if(is_array($mobiles))
            $mobiles = implode(',', $mobiles);
        return $mobiles;
    }
    /**
     * 处理短信内容数据
     * @author Lazy 2018-09-20
     * @param $data 数据内容
     * @return string
     */
    protected function parseData($data) {
        return empty($data) ? '' : json_encode($data);
    }
    /**
     * 处理短信返回结果数据
     * @author Lazy 2018-09-20
     * @param $result 数据结果
     * @return boolean
     */
    protected function parseResult($result) {
        $this->code       = $result->Code;
        $this->message    = $result->Message;
        $this->request_id = $result->RequestId;
        if(strtolower($result->Code) == 'ok'){
            $this->biz_id = $result->BizId;
            return true;
        }
        //记录错误日志
        $this->writeLog($result);
        return false;
    }
    /**
     * 记录短信发送日志
     * @author Lazy 2019-01-03
     * @param array $data 短信内容
     * @return true
     */
    protected function sendLog($data) {
        Log::record(json_encode($data), 'sms');
        return true;
    }
    /**
     * 记录错误日志
     * @author Lazy 2018-09-20
     * @param $data 日志内容
     */
    protected function writeLog($data) {
        $data = [
            'code'    => $data->Code,
            'request' => $data->RequestId,
            'message' => $data->Message,
        ];
        Log::record("Send SMS Error:\n【Code】:{code}\n【RequestId】:{request}\n【Message】:{message}", 'sms', $data);
    }
}
