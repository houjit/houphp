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
// | 数据输出
// +----------------------------------------------------------------------
namespace hou\https;
use hou\components\Base;

class Response extends Base
{
    public $code = 0;

    public $result = [];

    public $msg = "success";

    public function send()
    {
        header('Content-Type:application/json; charset=utf-8');
        echo \json_encode([
            'data' => $this->result,
            'msg' => $this->msg,
            'code' => $this->code,
            'timestamp' => time()
        ]);
    }

    public function json($data = [])
    {
        $this->result = array_merge($this->result, $data);
        return $this;
    }
}