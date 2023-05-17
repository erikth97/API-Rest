<?php

namespace App\Config;

class ResponseHttp {

    public static $message = array(
        'status' => '',
        'message' =>''
   );

    public static function status200(string $res)
   {
         http_response_code(200);
         self::$message['status'] = 'ok';
         self::$message['message'] = $res;
         return self::$message;
   }

   public static function status201(string $res = 'Recurso creado')
   {
         http_response_code(201);
         self::$message['status'] = 'ok';
         self::$message['message'] = $res;
         return self::$message;
   }

   public static function status400(string $res = 'Solicitud enviada incompleta o en formato incorrecto')
   {
         http_response_code(400);
         self::$message['status'] = 'eror';
         self::$message['message'] = $res;
         return self::$message;
   }

   public static function status401(string $res = 'No tienes los privilegios para acceder al recurso')
   {
         http_response_code(401);
         self::$message['status'] = 'eror';
         self::$message['message'] = $res;
         return self::$message;
   }

   public static function status404(string $res = 'Parece que estas perdido, verifica la documentacion')
   {
         http_response_code(404);
         self::$message['status'] = 'eror';
         self::$message['message'] = $res;
         return self::$message;
   }

   public static function status500(string $res = 'Error interno en el servidor')
   {
         http_response_code(500);
         self::$message['status'] = 'eror';
         self::$message['message'] = $res;
         return self::$message;
   }
}

?>
