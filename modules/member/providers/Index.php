<?php

namespace mod\member\providers;

use mod\member\model\Member as Model;
// use mod\common\traits\BaseProviders;

class Index
{
    // 引入公共库
    // use BaseProviders;

    /**
     * @var Model
     */
    protected $model;

    // 指定验证器
    // protected $validate = null;

    // 验证不过能跳出异常
    // protected $failException = true;

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
    public function user_info($wechat_user) {
        $user_info = $this->model->getOnly(['open_id' => $wechat_user['openid']]);
        if( ! $user_info) {
            // 保存用户头像
            if ($wechat_user['headimgurl']) {
                $img_result = self::download_wechat_img($wechat_user['headimgurl'], $wechat_user['openid']);
                $img_path = $img_result ? $img_result : '';
            }
            // 创建用户
            $user_insert = [
                'open_id' => $wechat_user['openid'],
                'nick' => $wechat_user['nickname'],
                'avatar' => $img_path,
                'mobile' => 0,
                'viper' => 0,
                'vip_expire' => 0,
                'create_time' => time(),
            ];
            $this->model->add($user_insert);
            $user_info = $this->model->getOnly(['open_id' => $wechat_user['openid']]);
        }
        return $user_info;
    }
    private function download_wechat_img($imgurl,$openid) {
        $header = [
            'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:45.0) Gecko/20100101 Firefox/45.0',
            'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $imgurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($code == 200) {//把URL格式的图片转成base64_encode格式的！
            $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);
        }
        $img_content=$imgBase64Code;//图片内容
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_content, $result)) {
            $type = $result[2];//得到图片类型png jpg gif
            //相对路径
            $relative_path='/uploads/terrace/members';
            //绝对路径（$_SERVER['DOCUMENT_ROOT']为网站根目录）
            $absolute_path = $_SERVER['DOCUMENT_ROOT'].$relative_path;
            if(!file_exists($absolute_path)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($absolute_path, 0700);
            }
            //文件名
            $filename=$openid.".{$type}";
            $new_file = $absolute_path.$filename;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img_content)))) {
                return $relative_path.$filename;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
