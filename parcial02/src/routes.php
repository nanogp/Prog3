<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\compra;
use App\Models\ORM\compraControler;

include_once __DIR__ . '/app/compra.php';
include_once __DIR__ . '/app/compraControler.php';

return function (App $app) {
    $container = $app->getContainer();

  /*   $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    }); */

    $app->get('/prueba', compraControler::class . ':traerTodos');
};
