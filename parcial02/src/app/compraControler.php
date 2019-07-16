<?php

namespace App\Models\ORM;

use App\Models\ORM\compra;
use App\Models\IApiControler;

include_once __DIR__ . '/compra.php';
include_once __DIR__ . './modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class compraControler implements IApiControler
{
  public function Beinvenida($request, $response, $args)
  {
    $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");

    return $response;
  }

  public function TraerTodos($request, $response, $args)
  {
    //return compra::all()->toJson();
    $todos = compra::all();
    $newResponse = $response->withJson($todos, 200);
    return $newResponse;
  }

  public function TraerUno($request, $response, $args)
  {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);
    return $newResponse;
  }

  public function CargarUno($request, $response, $args)
  {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);
    return $response;
  }
  public function BorrarUno($request, $response, $args)
  {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);
    return $newResponse;
  }

  public function ModificarUno($request, $response, $args)
  {
    //complete el codigo
    $newResponse = $response->withJson("sin completar", 200);
    return   $newResponse;
  }
}
