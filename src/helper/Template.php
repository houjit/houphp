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
namespace hou\helper;
use hou\Config;
use hou\Singleton;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Template
{
    use Singleton;

    public $template;

    public function __construct()
    {
        $templateConfig = Config::get('template');
        $loader = new FilesystemLoader($templateConfig['path']);
        $this->template = new Environment($loader, array(
            'cache' => $templateConfig['cache'],
            'auto_reload' => true
        ));
    }

    public function clear()
    {
        if ($this->template)
        {
            $this->template->clearTemplateCache();
        }
    }
}