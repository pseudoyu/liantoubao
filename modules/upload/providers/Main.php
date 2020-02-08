<?php

namespace mod\upload\providers;

use app\http\exception\Error;

class Main
{
    // 头像上传文件大小限制
    const FILE_SIZE = 10 * 1024 * 1024;
    // 头像上传格式限制
    const FILE_EXTS = 'jpg,jpeg,png,gif';
    // 头像上传保存目录
    const FILE_SAVE = '/uploads/editor';
    // 富文本上传接口
    public function editor($file) {
        // 保存上传文件
        $rules = [
            'size' => self::FILE_SIZE,
            'ext'  => self::FILE_EXTS
        ];
        $path = env('root_path') . '/public' . self::FILE_SAVE;
        $info  = $file->validate($rules)->move($path);
        if ( ! $info)
            throw new Error($file->getError());
        $file_name = str_replace('\\', '/', $info->getSaveName());
        // 更新表字段
        return self::FILE_SAVE . '/' . $file_name;
    }
}
