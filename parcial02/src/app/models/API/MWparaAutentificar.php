<?php

namespace App\Models\API;

use Slim\App;
use App\Models\API\AutentificadorJWT;
use Exception;

include_once __DIR__ . '/AutentificadorJWT.php';

class MWparaAutentificar
{
    public function ValidarUsuario($request, $response, $next)
    {
        $objDelaRespuesta = new \stdclass();
        $objDelaRespuesta->respuesta = "";
        $objDelaRespuesta->ok = false;

        try {
            $token = null;
            if ($request->getHeader('token') != null) $token = $request->getHeader('token')[0];
            AutentificadorJWT::verificarToken($token);
            $objDelaRespuesta->ok = true;

            if ($objDelaRespuesta->ok) {
                $payload = AutentificadorJWT::ObtenerData($token);
                $request = $request->withAttribute('payload', $payload); //pasar datos a demas

                $response = $next($request, $response); //llamar proximo MW

            } else {
                $objDelaRespuesta->respuesta = 'Solo usuarios registrados';
            }
        } catch (Exception $e) {
            $objDelaRespuesta->respuesta = $e->getMessage();
        }

        if ($objDelaRespuesta->respuesta != "") {
            $newResponse = $response->write($response->withJson($objDelaRespuesta->respuesta, 401));
        } else {
            $newResponse = $response;
        }

        return $newResponse;
    }

    public static function encryptarClave($clave)
    {
        return  password_hash($clave, PASSWORD_BCRYPT);
    }

    public function verificarClave($claveIngresada, $claveEncryptada)
    {
        return password_verify($claveIngresada, $claveEncryptada);
    }
}
