<?php

namespace App\Models\API;

use Slim\App;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/MWparaAutentificar.php';

class MWparaUsuarios
{
    public function FiltrarUsuarios($request, $response, $next)
    {
        $payload = $request->getAttribute('payload');
        $newResponse = "";

        if ($payload->perfil == 'admin') {
            $response = $next($request, $response);
            $newResponse = $response;
        } else {
            $newResponse = $response->withJson("hola", 200);
        }
        return $newResponse;
    }

    public function SoloAdmin($request, $response, $next)
    {
        $payload = $request->getAttribute('payload');
        $newResponse = "";

        if ($payload->perfil == 'admin') {
            $response = $next($request, $response);
            $newResponse = $response;
        } else {
            $newResponse = $response->withJson("solo admin", 200);
        }
        return $newResponse;
    }

    public function ModificarUsuario($request, $response, $next)
    {
        $payload = $request->getAttribute('payload');
        $newResponse = "";

        if ($payload->perfil == 'admin') {
            $newResponse = $response;
        } else {
            foreach (json_decode($response->getBody(), true) as $usuario) {
                if ($usuario['id_usuario'] == $payload->id) {
                    array_push($usuarios, $usuario);
                }
            }
            $newResponse = $response->withJson($usuarios, 200);
        }

        $response = $next($request, $response);

        return $newResponse;
    }
}
