<?php
namespace mod\admin\providers;

use extend\facade\Sms;
use mod\admin\model\Admin as Model;
use mod\common\traits\BaseProviders;
use app\http\exception\Error;
use think\facade\Cache;
use mod\admin\providers\Common;
class Index {
    // 引入公共库
    use BaseProviders;
    /**
     * @var Model
     */
    protected $model;
    // 指定验证器
    protected $validate = \mod\admin\validate\Admin::class;
    // 验证不过能跳出异常
    protected $failException = true;
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
    /**
     * 管理员后台登陆逻辑
     * @param $username
     * @param $passwd
     * @return mixed
     * @throws Error
     */
    public function login($username, $passwd) {
        // 验证参数是否合法
        $this->validate(compact('username', 'passwd'), 'login');
        // 根据用户名读取指定用户
        $field = 'id,username,passwd,nick,avatar,mobile,solt';
        $result = $this->model->getOnly(['username' => $username], $field);
        // 验证用户名与密码
        if (empty($result) || $result->passwd != Common::encrypt($passwd, $result->solt))
            throw new Error('用户名或密码不正确');
        // 保存登陆信息
        session(Common::SESSION_KEY, $result->hidden(['passwd'])->toArray());
        // 返回用户信息
        return $result->visible(['username', 'nick', 'avatar', 'mobile']);
    }
    // 注销登陆
    public function login_out() {
        session(Common::SESSION_KEY, null);
        return true;
    }
    /**
     * 验证短信发送频率是否在限制犯围内
     */
    protected function sms_rate() {
        $log      = Cache::get('ADMIN_PWD_CODE') ?: [
            'nums'        => 0,
            'create_time' => $_SERVER['REQUEST_TIME']
        ];
        $log['interval'] = ($_SERVER['REQUEST_TIME'] - $log['create_time']);
        if ($log['nums'] > 14 && $log['interval'] < 3600)
            throw new Error('短信发送频率过快，请稍后重试');
        return $log;
    }
    /**
     * 更新短信发送频率记录
     */
    protected function update_rate($log) {
        // 刷新发送频率记数
        Cache::set('ADMIN_PWD_CODE', [
            'nums'        => $log['interval'] > 3600 ? 0 : ++$log['nums'],
            'create_time' => $_SERVER['REQUEST_TIME']
        ]);
    }
    /**
     * 发送密码重置短信验证码
     * @param string $mobile
     */
    public function send_check($mobile) {
        // 验证短信发送频率是否超限制
        $log = $this->sms_rate();
        // 验证参数是否合法
        $condition = compact('mobile');
        $this->validate($condition, 'passwd');
        // 验证手机号是否正确
        if ( ! $this->model->getCount($condition))
            throw new Error('无效的手机号码');
        // 生成验证码
        $code = rand_str(6, '0123456789');
        session('ADMIN_PWD_CODE', [
            'code' => md5($code),
            'expire' => $_SERVER['REQUEST_TIME'] + 15 * 60
        ]);
        if (Sms::send($mobile, 'ADMIN_PWD_CODE', compact('code'))) {
            // 刷新发送频率记数
            $this->update_rate($log);
            return true;
        }
        return false;
    }
    /**
     * 发送密码重置通知
     * @param $mobile
     * @param $code
     */
    public function retrieve($mobile, $code) {
        // 验证参数是否合法
        $this->validate(compact('mobile', 'code'), 'retrieve');
        $result = $this->model->getOnly(['mobile' => $mobile], 'id,username,passwd,solt');
        if ( ! $result)
            throw new Error('无效的手机号码');
        // 重置密码
        $passwd = rand_str(8);
        $result->passwd = Common::encrypt($passwd, $result->solt);
        if ($result->save()) {
            // 发送短信通知
            $args = [
                'username' => $result->username,
                'passwd' => $passwd
            ];
            Sms::send($mobile, 'ADMIN_PWD_CODE', $args);
            return true;
        }
        return false;
    }
}