<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if ( ! function_exists('wrong')) {
    /**
     * 获取\think\response\Json对象实例,并返回错误信息
     * @author Lazy 2018-08-15
     * @param        $msg  文本信息
     * @param int    $code 状态码
     * @param string $url  跳转地址
     * @param mixed  $data 其它数据
     * @return Response
     */
    function wrong($msg, $code = 500, $url = '', $data = null) {
        return complete($msg, $code, $url, $data);
    }
}
if ( ! function_exists('complete')) {
    /**
     * 获取\think\response\Json对象实例
     * @author Lazy 2018-08-15
     * @param        $msg  文本信息
     * @param int    $code 状态码
     * @param string $url  跳转地址
     * @param mixed  $data 其它数据
     * @return Response
     */
    function complete($msg, $code = 200, $url = '', $data = null) {
        $msg = compact('code', 'msg', 'url');
        $data && $msg['data'] = $data;
        return \think\Response::create($msg, 'json', 200, [], []);
    }
}
if ( ! function_exists('output')) {
    /**
     * 获取\think\response\Json对象实例
     * @author Lazy 2018-09-26
     * @param array $data 返回的data数据
     * @return Response
     */
    function output($data = []) {
        $code = 200;
        $data = compact('code', 'data');
        return \think\Response::create($data, 'json', 200, [], []);
    }
}
if ( ! function_exists('rand_str')) {
    /**
     * 根据字符池中生成随机指定长度的字符串
     * @author Lazy 2018-11-02
     * @param int    $length 字符串长度
     * @param string $strs   字符池
     * @return string
     */
    function rand_str($length, $strs = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $total = strlen($strs) - 1;
        $str = '';
        for ($i = 0; $i < $length; $i++)
            $str .= $strs{mt_rand(0, $total)};
        return $str;
    }
}
if ( ! function_exists('hide_mobile')) {
    /**
     * 隐藏手机号码
     * @author Lazy 2018-12-27
     * @param string $mobile 待隐藏的手机号码
     * @return string
     */
    function hide_mobile($mobile) {
        return empty($mobile) ? ''
            : preg_replace('@^(\d{3})\d{4}(\d{4})$@', '${1}****${2}', $mobile);
    }
}
