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
// | * 基类控制器
// | * 预定义json方法，便于其他控制器使用
// | * 返回格式
// | {
// |     "data": [],
// | "msg": "success",
// | "code": 0,
// | "timestamp": 1572231957
// | }
// +----------------------------------------------------------------------
namespace hou\https;

class Controller
{
    protected $response;

    protected $code = 200;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function json($data = [])
    {
        return $this->response->json($data);
    }

    public function index($params)
    {
        return $this->response->json(['hello' => 'saif']);
    }
}