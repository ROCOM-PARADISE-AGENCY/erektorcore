<?php
/**
 * Created by PhpStorm.
 * User: Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * Date: 12/3/2020
 * Time: 5:38 PM
 * Erektor2 MVC Framework
 */

namespace rpa\erektorcore;


/**
 * Class Request
 *
 * @author Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * @package rpa\erektorcore
 */
class Request
{
    public function getPath() : string
    {
        $path = substr( $_SERVER['REQUEST_URI'], 1) ?? '/';
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        $path = substr($path, 0, $position);
        return $path;
    }

    public function method() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet() : bool
    {
        return $this->method() === 'get';
    }

    public function isPost() :bool
    {
        return $this->method() === 'post';
    }

    public function getBody() : array
    {
        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}