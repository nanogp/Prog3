<?php

use Slim\App;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/app/models/API/MWparaAutentificar.php';

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    /* $app->add(MWAutentificador::class . ':ValidarUsuario'); */
};
