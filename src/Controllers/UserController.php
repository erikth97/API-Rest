<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\UserModel;

class UserController
{
    private static $validate_rol = '/^[1,2,3]{1,1}$/';
    private static $validate_number = '/^[0-9]+$/';
    private static $validate_text = '/^[a-zA-Z]+$/';

    public function __construct(
        private string $method,
        private string $route,
        private array $params,
        private $data,
        private $headers
    ) 
    {}

    final public function getLogin(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            $email = strtolower($this->params[1]);
            $password = $this->params[2];

            if(empty($email) || empty($password)){
                echo json_encode(ResponseHttp::status400('Todos los campos son ncesesarios'));
            }else if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
                echo json_encode(ResponseHttp::status400('Formato de correo invalido'));
            }else{
                UserModel::setEmail($email);
                UserModel::setPassword($password);
                echo json_encode(UserModel::login());
            }
        exit;
        }
    }

    final public function getAll(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            Security::validateTokenJwt($this->headers,Security::secretKey());
            echo json_encode(UserModel::getAll());
            exit;
        }
    }

    final public function getUser(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            Security::validateTokenJwt($this->headers,Security::secretKey());
            $cedula = $this->route[1];
            if(!isset($cedula)) {
                echo json_encode(ResponseHttp::status400('El campo Cedula es requerido'));
            }else if (!preg_match((self::$validateNumber, $cedula)) {
                echo json_encode(ResponseHttp::status400());
            }else {
                UserModel::setCedula($dni);
                echo json_encode(UserModel::getUser());
                exit;
            }
            exit;
            )
            
            echo json_encode(UserModel::getUser());
            exit;
        }
    }


    final public function post(string $endPoint)
    {
        if ($this->method == 'post' && $endPoint == $this->route) {
            Security::validateTokenJwt($this->headers,Security::secretKey());

            if (empty($this->data['name']) || empty($this->data['dni']) || empty($this->data['email']) ||
            empty($this->data['rol']) || empty($this->data['password']) || empty($this->data['confirmPassword'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else if (!preg_match(self::$validate_text, $this->data['name'])) {
                echo json_encode(ResponseHttp::status400('El campo nombre solo admite texto'));
            } else if (!preg_match(self::$validate_number, $this->data['dni'])) {
                echo json_encode(ResponseHttp::status400('El campo dni solo admite numeros'));
            } else if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(ResponseHttp::status400('Formato de correo incorrecto'));
            } else if (!preg_match(self::$validate_rol, $this->data['rol'])) {
                echo json_encode(ResponseHttp::status400('Rol invalido'));
            } else if (strlen($this->data['password']) < 8 || strlen($this->data['confirmPassword']) < 8) {
                echo json_encode(ResponseHttp::status400('La contraseña debe de tener un minimo de 8 caracteres'));
            } else if ($this->data['password'] !== $this->data['confirmPassword']) {
                echo json_encode(ResponseHttp::status400('las contraseñas no coinciden'));
            } else {
                new UserModel($this->data);
                echo json_encode(UserModel::post());
            }
            exit;
        }
    }
}
