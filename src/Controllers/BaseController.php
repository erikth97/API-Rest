<?php
namespace App\Controllers;

class BaseController {

    protected static $validate_number = '/^[0-9]+$/';
    protected static $validate_text = '/^[a-zA-Z ]+$/';
    protected static $validate_rol = '/^[1,2,3]{1,1}$/';
    protected static $validate_stock = '/^[0-9]{1,}$/';
    protected static $validate_description = '/^[a-zA-Z ]{1,30}$/';

    protected static function validateEmail(string $email)
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    protected function getMethod()
    {
       return strtolower($_SERVER['REQUEST_METHOD']);
    }

    protected function getRoute()
    {
       return $_GET['route'];
    }

    protected function getAttribute()
    {
        $route = $this->getRoute();
        $params = explode('/',$route);
        return $params;
    }

    protected function getHeader(string $header)
    {
        $ContentType = getallheaders();
        return $ContentType[$header];
    }

    protected function getParam()
    {
        if ($this->getHeader('Content-Type') == 'application/json') {
           $param = json_decode(file_get_contents("php://input"),true);
        } else {
            $param = $_POST;
        }
        return $param;
    }
}
