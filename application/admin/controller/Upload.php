<?php
namespace app\admin\controller;

use think\Request;
use mod\upload\providers\Main;
use app\http\exception\Error;

class Upload {
    protected $uploader;

    public function __construct(Main $upload) {
        $this->uploader = $upload;
    }
    /**
     * 上传新的头像
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function editor(Request $request) {
        $file   = $request->file('file');
        try {
            $file_name = $this->uploader->editor($file);
            return output($file_name);
        } catch (Error $e) {
            return wrong($e->getMessage());
        }
    }
}
