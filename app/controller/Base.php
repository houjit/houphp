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
namespace app\controller;
use hou\mvc\Controller;

abstract class Base extends Controller
{
    /**
     * @param $data
     * @param string $tplFile
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @desc 渲染模板
     */
    public function template($data, $tplFile = '')
    {
        if ('' == $tplFile)
        {
            $tplFile = $this->request->getAttribute(self::_CONTROLLER_KEY_)
                . DS . $this->request->getAttribute(self::_METHOD_KEY_)
                . '.twig';
        }
        return $this->template->render($tplFile, $data);
    }

    public function json($data)
    {
        return json_encode([
            'code' => 0,
            'msg' => '',
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
    }

    public function render($data)
    {
        return [
            'code' => 0,
            'msg' => '',
            'data' => $data
        ];
    }


}