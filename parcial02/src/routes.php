<?php

use Slim\App;
use App\Models\ORM\UsuarioController;
use App\Models\ORM\CompraController;
use App\Models\API\MWparaAutentificar;
use App\Models\API\MWparaLogs;
use App\Models\API\MWparaUsuarios;
use App\Models\API\MWparaCompras;
use App\Models\ORM\LogController;

include_once __DIR__ . '/app/models/ORM/Usuario.php';
include_once __DIR__ . '/app/models/ORM/UsuarioController.php';
include_once __DIR__ . '/app/models/ORM/Compra.php';
include_once __DIR__ . '/app/models/ORM/CompraController.php';
include_once __DIR__ . '/app/models/API/MWparaAutentificar.php';
include_once __DIR__ . '/app/models/API/MWparaLogs.php';
include_once __DIR__ . '/app/models/API/MWparaUsuarios.php';
include_once __DIR__ . '/app/models/API/MWparaCompras.php';

return function (App $app) {

    $container = $app->getContainer();
    /*   $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '[/]' route");

        // Render index views
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    }); */

    $app->get('/prueba', function () {
        echo "probando";
    });

    $app->group('/login', function () {
        $this->post('[/]', UsuarioController::class . ':Login');
    });

    $app->group('/usuario', function () {
        $this->get('[/]', UsuarioController::class . ':TraerTodos')->add(MWparaUsuarios::class . ':FiltrarUsuarios');
        $this->get('/TraerUno', UsuarioController::class . ':TraerUno')->add(MWparaUsuarios::class . ':SoloAdmin');
        $this->put('[/]', UsuarioController::class . ':ModificarUno');
        $this->delete('[/]', UsuarioController::class . ':BorrarUno')->add(MWparaUsuarios::class . ':SoloAdmin');
    })->add(MWparaLogs::class . ':GuardarLog')->add(MWparaAutentificar::class . ':ValidarUsuario');

    $app->group('/compra', function () {
        $this->get('[/]', CompraController::class . ':TraerTodos')->add(MWparaCompras::class . ':FiltrarCompras');
        $this->get('/TraerUno', CompraController::class . ':TraerUno');
        $this->post('[/]', CompraController::class . ':CargarUno');
        $this->put('[/]', CompraController::class . ':ModificarUno');
        $this->delete('[/]', CompraController::class . ':BorrarUno')->add(MWparaUsuarios::class . ':SoloAdmin');
    })->add(MWparaLogs::class . ':GuardarLog')->add(MWparaAutentificar::class . ':ValidarUsuario');

    $app->group('/comprasconfoto', function () {
        $this->get('[/]', CompraController::class . ':TraerTodosConFoto');
    });

    $app->group('/comprasporusuario', function () {
        $this->get('[/]', CompraController::class . ':TraerPorUsuario');
    });

    $app->group('/log', function () {
        $this->get('[/]', LogController::class . ':TraerPorMetodo');
    });

    $app->post('/usuario[/]', UsuarioController::class . ':CargarUno');
};
