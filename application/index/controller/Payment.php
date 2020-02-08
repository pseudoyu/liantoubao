<?php

namespace app\index\controller;

use think\Request;
use mod\services\providers\Manage;

class Payment
{
    protected $provider;

    public function __construct(Manage $manage) {
        $this->provider = $manage;
    }
    public function services($id) {
        return output($this->provider->find($id));
    }
}
