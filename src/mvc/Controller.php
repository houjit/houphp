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
namespace hou\mvc;
use hou\Config;
use hou\helper\Template;
use hou\pool\Context;

class Controller
{

    /**
     * @var \EasySwoole\Http\Request
     */
    protected $request;
    /**
     * @var \Twig\Environment
     */
    protected $template;

    const _CONTROLLER_KEY_ = '__CTR__';
    const _METHOD_KEY_ = '__METHOD__';

    public function __construct()
    {
        //通过context拿到$request, 再也不用担收数据错乱了
        /**
         * @var $context \hou\coroutine\Context
         */
        $context = Context::getInstance()->get();
        $this->request = $context->getRequest();
        $this->template = Template::getInstance()->template;
    }

}