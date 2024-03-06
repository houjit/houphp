<?php declare(strict_types=1);
// +----------------------------------------------------------------------
// | houoole [ 厚匠科技 https://www.houjit.com ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: amos <amos@houjit.com>
// +----------------------------------------------------------------------
namespace app\controller;

class Index
{
    public function index($request, $response)
    {
        $response->end(
            json_encode(
                [
                    'method' => $request->server['request_method'],
                    'message' => 'Hello houoole.',
                ]
            )
        );
    }

    public function hello($request, $response, $data)
    {
        $name = $data['name'] ?? 'houoole';

        $response->end(
            json_encode(
                [
                    'method' => $request->server['request_method'],
                    'message' => "Hello {$name}.",
                ]
            )
        );
    }
}
