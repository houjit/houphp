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

defind("ROOT_PATH",__DIR__);

var_dump(ROOT_PATH);

//是否composer
if (! file_exists('../vendor'))
{
    exit('根目录缺少vendor,请先composer install');
}

require __DIR__.DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'hou' . DIRECTORY_SEPARATOR . 'System.php';

// 加载配置
$config = require SF_LIBRARY_PATH.'Config.php';
$appConfig = file_exists($appConfigPath = SF_APP_PATH.'Config.php') ? require $appConfigPath : [];
$config = array_merge($config, $appConfig);

$config['debug'] = ($config['debug']?? SF_DEBUG);

if ($config['debug']) {
    ini_set("display_errors", "On");
    error_reporting(E_ALL);
}

// composer自动加载
require __DIR__ . '/../vendor/autoload.php';

// 实例化应用并运行
$app = new hou\Application(new hou\https\Request() ,$config);
$app->run();