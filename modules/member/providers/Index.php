<?php

namespace mod\member\providers;

use app\http\exception\Error;
use mod\member\model\Member as Model;
use think\Image;
use think\Request;

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

    // 头像上传文件大小限制
    const AVATAR_SIZE = 10 * 1024 * 1024;
    // 头像上传格式限制
    const AVATAR_EXTS = 'jpg,png,gif';
    // 头像上传mime格式限制
    const AVATAR_TYPE = 'image/jpg,image/jpeg,image/png,image/gif';
    // 头像上传保存目录
    const AVATAR_SAVE = '/uploads/terrace/members';
    /**
     * Index constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    public function user_info($wechat_user) {
        //var_dump($wechat_user);exit;
        $user_info = $this->model->getOnly(['open_id' => $wechat_user['id']]);
        if( ! $user_info) {
            // 保存用户头像
            if ($wechat_user['avatar']) {
                $img_result = self::download_wechat_img($wechat_user['avatar'], $wechat_user['id']);
                $img_path = $img_result ? $img_result : '';
            }
            // 创建用户
            $user_insert = [
                'open_id' => $wechat_user['id'],
                'nick' => $wechat_user['nickname'],
                'avatar' => $img_path,
                'mobile' => 0,
                'viper' => 0,
                'vip_expire' => 0,
                'create_time' => time(),
            ];
            $this->model->add($user_insert);
            $user_info = $this->model->getOnly(['open_id' => $wechat_user['id']]);
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
            $relative_path='/uploads/terrace/members/'.date('Ymd').'/';
            //绝对路径（$_SERVER['DOCUMENT_ROOT']为网站根目录）
            $absolute_path = env('root_path') .'/public'. $relative_path;
            if(!file_exists($absolute_path)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($absolute_path, 0700, true);
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
    /**
     * 更新头像
     * @param $id
     * @param $file Request::file('image')
     */
    public function updateAvatar($id, $file) {
        // 保存上传文件
        $rules = [
            'size' => self::AVATAR_SIZE,
            // 'ext'  => self::AVATAR_EXTS,
            'type' => self::AVATAR_TYPE
        ];
        $path = env('root_path') . 'public' . self::AVATAR_SAVE;
        // 生成文件名
        $date = date('Ymd', $_SERVER['REQUEST_TIME']) . '/';
        $ext  = substr(strrchr($file->getInfo('type'), '/'), 1);
        $ext === 'jpeg' && $ext = 'jpg';
        $file_name = $date . rand_str(32) . '.' . $ext;
        $info  = $file->validate($rules)->move($path, $file_name);
        if ( ! $info)
            throw new Error($file->getError());
        $file_name = str_replace('\\', '/', $info->getSaveName());
        // 按照原图的比例生成一个最大为200*200的缩略图并替换
        $corp  = $path . '/' . $file_name;
        $image = Image::open($corp);
        $image->thumb(200, 200, Image::THUMB_CENTER)->save($corp);
        // 更新表字段
        $avatar = self::AVATAR_SAVE . '/' . $file_name;
        if ( ! $this->updateInfo($id, ['avatar' => $avatar]))
            throw new Error('头像上传失败');
        return $avatar;
    }
    /**
     * 更新字段
     * @param $id
     * @param $data
     */
    public function updateInfo($id, $data) {
        return $this->model->modify(['id' => $id], $data);
    }
    public function getByUid($uid) {
        return $this->model->getOnly(['id' => $uid]);
    }
    public function getByUids($uids) {
        return $this->model->whereIn('id', $uids)->select();
    }
    public function getAll() {
        return $this->model->getList([], false)->toArray();
    }
}
