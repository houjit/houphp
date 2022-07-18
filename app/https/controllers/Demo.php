<?php
// +----------------------------------------------------------------------
// | HouCMF [ 用心做好每个站 用心服务好每个客户 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://www.houjit.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Amos <amos@houjit.com>
// +----------------------------------------------------------------------
namespace app\https\controllers;
use hou\https\controller;

class Demo extends Controller
{
    public function welcome($params)
    {
        return $this->response->json(['hello' => 'welcome']);
    }

    public function test($params)
    {
        return $this->response->json($params);
    }
}