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
namespace hou;
use hou\exceptions\SaiException;
use hou\https\Request;
use hou\https\Response;

class Application
{
    // app应用控制器命名空间
    private $controllerNameSpace = 'app\\https\\controllers\\';

    // 之前定义的基类控制器
    private $baseController = 'library\\https\\controller';

    private $config;

    private $request;

    public function __construct(Request $request, $config = [])
    {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * 运行应用并输出数据
     * @return bool
     */
    public function run()
    {
        try {
            $response = $this->handleRequest($this->request);
            $response->send();
            return $response->exitStatus;
        } catch (SaiException $e) {
            $e->response($e->getCode(), [
                'line' => $e->getLine(),
                'msg' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
            ]);
            return false;
        }
    }

    /**
     * 控制器处理
     * @param $route
     * @return mixed
     * @throws NotFoundException
     */
    public function runAction($route)
    {
        if (array_key_exists($route, $this->_route)) {
            $route = $this->_route[$route];
        }

        $match = explode('/', $route);
        $match = array_filter($match);

        // 处理$route=/
        if (empty($match)) {
            $match = ['index'];
            $controller = $this->createController($match);
            $action = 'index';

            // 处理$route=index
        } elseif (count($match) < 2) {
            $controller = $this->createController($match);
            $action = 'index';
        } else {
            $action = array_pop($match);
            $controller = $this->createController($match);

            if (!method_exists($controller, $action)) {
                throw new NotFoundException("method not found:".$action);
            }
        }

        // 将get和post注入控制器方法中
        return $controller->$action(array_merge($this->getQueryParams(), $this->getBodyParams()));
    }

    public function createController($match)
    {
        $controllerName = $this->controllerNameSpace;

        foreach ($match as $namespace) {
            $controllerName .= ucfirst($namespace).'\\';
        }

        $controllerName = rtrim($controllerName,'\\').'Controller';

        if (!class_exists($controllerName)) {
            if ($controllerName == $this->controllerNameSpace.'IndexController') {
                return new $this->baseController;
            }
            throw new NotFoundException("controller not found:".$controllerName);
        }

        return new $controllerName;
    }
    /**
     * 返回不含参数的REQUEST_URI地址
     */
    public function resolve($route=[])  {
        $this->route = $route;  // 自定义路由
        return $this->getPathUrl();
    }

    private $pathUrl;

    /**
     * 获取请求地址
     * @return bool|mixed|string
     */
    public function getPathUrl()
    {
        if (is_null($this->pathUrl)) {
            $url = trim($_SERVER['REQUEST_URI'], '/');
            $index = strpos($url, '?');
            $this->pathUrl = ($index > -1) ? substr($url, 0, $index) : $url;
        }

        return $this->pathUrl;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws SaiException
     */
    public function handleRequest(Request $request)
    {
        $route = $request->resolve($this->_config['route']??[]);

        $response = $request->runAction($route);
        /**
         * 执行结果赋值给$response->data，并返回给response对象
         */
        if ($response instanceof Response) {
            return $response;
        }

        throw new SaiException('Content format error');
    }

}