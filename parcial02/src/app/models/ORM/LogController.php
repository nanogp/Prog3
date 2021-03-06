<?php

namespace App\Models\ORM;

use App\Models\ORM\Log;
use App\Models\API\IApiController;

require_once __DIR__ . '/log.php';
include_once __DIR__ . '../../API/IApiController.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class LogController implements IApiController
{
    public static function getPropertiesFull()
    {
        return array(
            'id',
            'usuario',
            'metodo',
            'ruta',
            'fechahora',
            'created_at',
            'updated_at'
        );
    }

    public static function getPk()
    {
        return array(
            'id'
        );
    }

    public static function getPropertiesRequired()
    {
        return array(
            'usuario',
            'metodo',
            'ruta'
        );
    }

    public static function getPropertiesMetodo()
    {
        return array(
            'metodo'
        );
    }

    public static function getPropertiesTabla()
    {
        return array(
            'id',
            'usuario',
            'metodo',
            'ruta',
            'fechahora'
        );
    }

    //---------------------------------------------- medatos
    public function TraerTodos($request, $response, $args)
    {
        $datos = Log::all();
        $retorno = $response->withJson($datos, 200);
        return $retorno;
    }

    public function TraerPorMetodo($request, $response, $args)
    {
        $respuesta = 'no hay datos para ese metodo';
        $parametros = array(self::getPropertiesMetodo()[0] => $request->getQueryParam(self::getPropertiesMetodo()[0]));
        $datos = buscarPorBaseTodos(Log::class, $parametros);
        if (!$datos->isEmpty()) {
            $strHtml = "<table border='1' style='border-collapse: collapse'>";
            foreach ($datos as $dato) {
                foreach (self::getPropertiesTabla() as $key) {
                    $strHtml .= "<th>" . strtoupper($key) . "</th>";
                }
                break;
            }

            $strHtml .= "<tbody>";
            foreach ($datos as $dato) {
                $strHtml .= "<tr>";
                foreach (self::getPropertiesTabla() as $key) {
                    $strHtml .= "<td>$dato[$key]</td>";
                }
                $strHtml .= "</tr>";
            }
            $strHtml .= "</tbody>";
            $respuesta = $strHtml;
        }
        return $respuesta;
    }

    public function TraerUno($request, $response, $args)
    {
        $respuesta = 'datos no existentes';
        $pk = createArray($_GET, self::getPkCompra());
        $dato = buscar(Log::all(), $pk);
        if ($dato) $respuesta = $dato;
        $retorno = $response->withJson($respuesta, 200);
        return $retorno;
    }

    public function CargarUno($request, $response, $args)
    {
        // $parametros['id_usuario'] = AutentificadorJWT::ObtenerData($request->getHeader('token')[0])->id;
        $parametros['usuario'] = $request->getAttribute('payload')->nombre;
        $parametros['metodo'] = $request->getMethod();
        $parametros['ruta'] = $request->getUri()->getPath();
        $dato = createProperties(new Log(), $parametros, self::getPropertiesRequired());
        $dato->save();
        return $request;
    }

    public function BorrarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_DELETE);
        $pk = createArray($_DELETE, self::getPk());

        $dato = buscar(Log::all(), $pk);
        if ($dato) {
            $dato->delete();
            $textoResponse = "id $dato->id borrado";
        }
        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }
    public function ModificarUno($request, $response, $args)
    { }
}
