<?php

namespace App\Models\API;

use Slim\App;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/MWparaAutentificar.php';

class MWparaCompras
{
    public function FiltrarCompras($request, $response, $next)
    {
        $response = $next($request, $response);

        $payload = $request->getAttribute('payload');
        $newResponse = "";

        if ($payload->perfil == 'admin') {
            $newResponse = $response;
        } else {
            $compras = array();
            foreach (json_decode($response->getBody(), true) as $compra) {
                if ($compra['id_usuario'] == $payload->id) {
                    array_push($compras, $compra);
                }
            }
            $newResponse = $response->withJson($compras, 200);
        }
        return $newResponse;
    }
}
