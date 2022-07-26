<?php
/**
 * Created by PhpStorm.
 * User: shenzhe
 * Date: 2018-12-24
 * Time: 10:58
 */

namespace hou\mvc;


use hou\Config;

class View
{
    public function render($data)
    {
        $mode = Config::get('view_mode', 'Json');

    }
}