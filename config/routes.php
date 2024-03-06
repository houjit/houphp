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
return [
    ['GET', '/', '\app\controller\IndexController@index'],
    ['GET', '/hello[/{name}]', '\app\controller\IndexController@hello'],
    ['GET', '/favicon.ico', function ($request, $response) {
        $response->end('');
    }],
];
