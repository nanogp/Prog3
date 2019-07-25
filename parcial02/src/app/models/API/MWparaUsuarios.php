<?php

namespace App\Models\API;

use Slim\App;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/MWparaAutentificar.php';

class MWparaUsuarios
{
    public function FiltrarUsuarios($request, $response, $next)
    {
        $response = $next($request, $response);

        $payload = $request->getAttribute('payload');
        $newResponse = "";

        if ($payload->perfil == 'admin') {
            $newResponse = $response;
        } else {
            $newResponse = $response->withJson("hola", 200);
        }
        return $newResponse;
    }
}
