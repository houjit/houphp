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
declare (strict_types = 1);
use hou\App;

return [
    'template' => [
        //模板页面的存放目录
        'path' => App::$appPath . DS . 'template' . DS . 'default',    //模版目录, 空则默认 template/default
        //模板缓存页面的存放目录
        'cache' => App::$appPath . DS . 'template' . DS . 'default_cache',    //缓存目录, 空则默认 template/default_cache
    ]
];