<?php

namespace App\Models\API;

use Slim\App;
use App\Models\API\MWparaAutentificar;
use App\Models\ORM\LogController;

include_once __DIR__ . '/../ORM/LogController.php';

class MWparaLogs
{
    public function GuardarLog($request, $response, $next)
    {
        LogController::CargarUno($request, $response, $next);
        $response = $next($request, $response); //llamar proximo MW
        return $response;
    }
}
