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
// | 处理请求
// +----------------------------------------------------------------------
namespace hou\https;
use hou\components\Base;

class Request extends Base
{
    /**
     * 获取请求方法
     * @return string
     */
    public function getMethod()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return strtoupper($_SERVER['REQUEST_METHOD']);
        }
        return 'GET';
    }

    /**
     * 请求头
     * @param $name
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getHeader($name, $defaultValue = null)
    {
        $name = ucfirst($name);
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            return $headers[$name]?? $defaultValue;
        }
        $name = strtoupper($name);
        return $_SERVER[$name]?? $defaultValue;
    }

    /**
     * 获取get参数
     * @param null $name
     * @param null $defaultValue
     * @return |null
     */
    public function get($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->getQueryParams();
        }
        return $this->getQueryParam($name, $defaultValue);
    }

    public function getQueryParam($name, $defaultValue = null)
    {
        $params = $this->getQueryParams();
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function getQueryParams()
    {
        if (empty($this->queryParams)) {
            return $this->queryParams = $_GET;
        }
        return $this->queryParams;
    }

    /**
     * 获取post参数
     * @param null $name
     * @param null $defaultValue
     * @return array|mixed|null
     */
    public function post($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->getBodyParams();
        }
        return $this->getBodyParam($name, $defaultValue);
    }

    public function getBodyParam($name, $defaultValue = null)
    {
        $params = $this->getBodyParams();
        if (is_object($params)) {
            try {
                return $params->{$name};
            } catch (\Exception $e) {
                return $defaultValue;
            }
        }
        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function getBodyParams()
    {
        $contentType = strtolower($this->getHeader('Content-Type'));
        if ($contentType == 'multipart/form-data') {
            $this->bodyParams = $_POST;
        } else {
            $this->bodyParams = \json_decode(file_get_contents("php://input"), true);
        }
        return $this->bodyParams?? [];
    }

    /**
     * get参数数组
     */
    private $queryParams = [];

    /**
     * post参数数组
     */
    private $bodyParams = [];

    private $method;
}