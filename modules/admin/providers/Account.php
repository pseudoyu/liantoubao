<?php

namespace mod\admin\providers;

use app\http\exception\Error;
use mod\admin\model\Admin as Model;
use mod\common\traits\BaseProviders;
use think\Request;
use mod\admin\providers\Common;
use think\exception\ValidateException;
use think\Image;

class Account
{
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

    // 头像上传文件大小限制
    const AVATAR_SIZE = 1 * 1024 * 1024;
    // 头像上传格式限制
    const AVATAR_EXTS = 'jpg,png,gif';
    // 头像上传保存目录
    const AVATAR_SAVE = '/uploads/terrace/admins';
    /**
     * Actions constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    /**
     * updatePasswd
     * @author Lazy
     * @param $id
     * @param $data[passwd =>旧密码, new_passwd =>新密码, repeat_passwd =>重复新密码]
     */
    public function updatePasswd($id, $data) {
        $this->validate($data, 'update_passwd');
        // 比对旧密码是否正常
        $result = $this->model->getOnly(['id' => $id], 'id,passwd,solt');
        // 验证旧密码是否正确
        if ( ! $result)
            throw new Error('用户不存在或已被删除');
        if ($result->passwd != Common::encrypt($data['passwd'], $result->solt))
            throw new ValidateException('旧密码填写错误');
        // 更新密码
        $result->passwd = Common::encrypt($data['new_passwd'], $result->solt);
        return $result->save();
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
            'ext'  => self::AVATAR_EXTS
        ];
        $path = env('root_path') . '/public' . self::AVATAR_SAVE;
        $info  = $file->validate($rules)->move($path);
        if ( ! $info)
            throw new Error($info->getError());
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
     * 更新其它字段信息
     * @param $id
     * @param $data
     */
    public function updateInfo($id, $data, $scene = false) {
        if ($scene)
            $this->validate($data, $scene);
        return $this->model->modify(['id' => $id], $data);
    }
}
