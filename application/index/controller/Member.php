<?php
namespace app\index\controller;

use mod\member\providers\Follow;
use think\facade\Cache;
use think\Request;
use mod\member\providers\Index as Provider;
class Member {
    protected $provider;
    protected $admin_id;
    public function __construct(Provider $account) {
        $this->provider = $account;
    }
    /**
     * 其余帐号相关操作
     * @return \think\Response
     */
    public function update(Request $request) {
        //简写
        $data = $request->only(['mobile' => '', 'nick' => ''], 'put');
        $validate = new \app\index\validate\Member;
        if (!$validate->check($data)) {
            return wrong($validate->getError());
        }
        return $this->provider->updateInfo($request->uid, $data)
            ? complete('修改成功') : wrong('修改失败');
    }
    // 设置权限
    public function update_permission(Request $request) {
        $permission = $request->permission;
        $permission = in_array($permission, [1, 2, 3]) === false ? 1 : $permission;
        return $this->provider->updateInfo($request->uid, compact('permission'))
            ? complete('修改成功') : wrong('修改失败');
    }
    // 设置货币类型
    public function update_coin(Request $request) {
        $coin = strtoupper($request->put('coin', 'usd'));
        $coin = in_array($coin, ['USD', 'CNY']) === false ? 'USD' : $coin;
        return $this->provider->updateInfo($request->uid, compact('coin'))
            ? complete('修改成功') : wrong('修改失败');
    }
    /**
     * 上传新的头像
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function avatar(Request $request) {
        $file   = $request->file('file');
        if (! $file) {
            return wrong('图片不能为空');
        }
        $avatar = $this->provider->updateAvatar($request->uid, $file);
        return complete('头像上传成功', 200, '', compact('avatar'));
    }
    public function follow_member(Request $request) {
        $object_id = $request->object_id;
        if( ! $object_id) {
            return wrong('参数错误');
        }
        $uid = $request->uid;
        $object_info = $this->provider->getByUid($object_id);
        if ( ! $object_info) {
            return wrong('关注对象不存在');
        }
        // 检查是否是会员
//        $user_info = $this->provider->getByUid($uid);
//        if ($user_info['viper'] < 1) {
//            return wrong('无权限');
//        } else {
//            if($user_info['vip_expire'] > 0 && $user_info['vip_expire'] < time()) {
//                return wrong('无权限');
//            }
//        }
        // 关注
        return app(Follow::class)->follow($uid, $object_id) ? complete('关注成功') : wrong('关注失败');
    }
    public function cancel_follow(Request $request) {
        $object_id = $request->object_id;
        if( ! $object_id) {
            return wrong('参数错误');
        }
        // 关注
        return app(Follow::class)->cancel_follow($request->uid, $object_id) ? complete('取消成功') : wrong('取消失败');
    }
    public function follow_list(Request $request) {
        $list = app(Follow::class)->follow_list($request->uid);
        if( ! $list) {
            return output([]);
        }
        $rank_list = Cache::get('coin_rank');
        if ( !$rank_list) {
            return wrong('排行榜数据异常');
        }
        $follow = [];
        foreach ($list as $l) {
            $follow[] = $rank_list['data'][$l['object_id']];
        }
        return output($follow);
    }
    public function follow_user_info(Request $request) {

    }
}
