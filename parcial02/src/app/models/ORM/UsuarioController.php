<?php

namespace App\Models\ORM;

use App\Models\ORM\Usuario;
use App\Models\API\IApiController;
use App\Models\API\AutentificadorJWT;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/Usuario.php';
include_once __DIR__ . '/../API/IApiController.php';
include_once __DIR__ . '/../API/MWparaAutentificar.php';
include_once __DIR__ . '/../../common.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioController implements IApiController
{
    const ENCRIPTAR_CLAVES = false;

    //---------------------------------------------- devuelven arrays de datos obligatorios para cada request
    public static function getPropertiesFull()
    {
        return array(
            'id',
            'nombre',
            'clave',
            'perfil',
            'sexo',
            'created_at',
            'updated_at'
        );
    }

    public static function getPk()
    {
        return array(
            'nombre'
        );
    }

    public static function getPkLogin()
    {
        return array(
            'nombre',
            'clave',
            'sexo'
        );
    }

    public static function getPropertiesRequired()
    {
        return array(
            'nombre',
            'clave',
            'sexo'
        );
    }

    public static function getPropertiesMod()
    {
        return array(
            'sexo',
            'clave'
        );
    }

    public static function getPropertiesTabla()
    {
        return array(
            'id',
            'nombre',
            'clave',
            'perfil',
            'sexo'
        );
    }
    //---------------------------------------------- metodos
    public function Login($request, $response, $args)
    {
        $respuesta = 'datos no existentes';
        $pk = createArray($request->getParsedBody(), self::getPkLogin());
        $todos = Usuario::all();
        $estado = 'APROBAR_NOMBRE';
        $nombreOk[] = null;
        $sexoOk[] = null;

        foreach ($todos as $usuario) {
            if ($usuario['nombre'] == $pk['nombre']) {
                $estado = 'APROBAR_SEXO';
                $nombreOk[] = $usuario;
            }
        }

        foreach ($nombreOk as $usuario) {
            if ($usuario['sexo'] == $pk['sexo']) {
                $estado = 'APROBAR_CLAVE';
                $sexoOk[] = $usuario;
            }
        }

        foreach ($sexoOk as $usuario) {
            if ($usuario['clave'] == $pk['clave'] || MWparaAutentificar::verificarClave($pk['clave'], $usuario['clave'])) {
                $estado = 'OK';
                $dato = $usuario;
                break;
            }
        }

        switch ($estado) {
            case 'APROBAR_NOMBRE':
                $respuesta = 'no existe el usuario ' . $pk['nombre'];
                break;

            case 'APROBAR_SEXO':
                $respuesta = 'no coincide el sexo';
                break;

            case 'APROBAR_CLAVE':
                $respuesta = 'no coincide la clave';
                break;

            case 'OK':
                $respuesta = AutentificadorJWT::CrearToken($dato);
                break;
        }

        $retorno = $response->withJson($respuesta, 200);

        return $retorno;
    }

    public function TraerUno($request, $response, $args)
    {
        $respuesta = 'datos no existentes';
        $parametros['nombre'] = $request->getQueryParam('nombre');
        $dato = buscarPorBase(Usuario::class, $parametros);
        // $dato = buscar(Usuario::all(), $pk);
        if ($dato) $respuesta = $dato;
        $retorno = $response->withJson($respuesta, 200);
        return $retorno;
    }

    public function TraerTodos($request, $response, $args)
    {
        $todos = Usuario::all();
        $retorno = $response->withJson($todos, 200);
        return $retorno;
    }

    public function CargarUno($request, $response, $args)
    {
        $dato = createProperties(new usuario(), $request->getParsedBody(), self::getPropertiesRequired());
        if ($dato->perfil == null) $dato->perfil = 'usuario';
        if (self::ENCRIPTAR_CLAVES) $dato->clave = MWparaAutentificar::encryptarClave($dato->clave);
        $dato->save();
        $retorno = $response->withJson("id $dato->id cargado", 200);
        return $retorno;
    }

    public function BorrarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_DELETE);
        $pk = createArray($_DELETE, self::getPk());

        $dato = buscar(Usuario::all(), $pk);
        if ($dato) {
            $dato->delete();
            $textoResponse = "id $dato->id: $dato->nombre, borrado";
        }
        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }

    public function ModificarUno($request, $response, $args)
    {
        $textoResponse = 'datos no validos';
        parse_str(file_get_contents("php://input"), $_PUT);
        $parametros[self::getPk()[0]] = $request->getAttribute('payload')->{self::getPk()[0]};
        $dato = buscarPorBase(Usuario::class, $parametros);

        if ($dato) {
            foreach (self::getPropertiesMod() as $key) {
                $dato[$key] = $_PUT[$key];
            }
            $dato->save();
            $textoResponse = "se actualizo el usuario: " . $dato->{self::getPk()[0]};
        }

        // $textoResponse = 'no se encontro el usuario';
        // parse_str(file_get_contents("php://input"), $_PUT);
        // $pk = createArray($_PUT, self::getPk());

        // $dato = buscar(Usuario::all(), $pk);
        // if ($dato) {
        //     foreach (self::getPropertiesMod() as $key) {
        //         $dato[$key] = $_PUT[$key];
        //     }
        //     $dato->save();
        //     $textoResponse = "se actualizo el usuario: $dato->id";
        // }
        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }
}
