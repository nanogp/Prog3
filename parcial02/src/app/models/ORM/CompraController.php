<?php

namespace App\Models\ORM;

use App\Models\ORM\Compra;
use App\Models\API\IApiController;
use App\Models\API\AutentificadorJWT;

include_once __DIR__ . '/Usuario.php';
include_once __DIR__ . '/../API/IApiController.php';
include_once __DIR__ . '/../API/AutentificadorJWT.php';
include_once __DIR__ . '/../../common.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use MWparaAutentificar;


class CompraController implements IApiController
{
    const rutaImgCompras = __DIR__ . "/../../IMGCompras/";
    const rutaBackupImg = __DIR__ . "/../../IMGCompras/backup/";
    const rutaImgMarcaDeAgua = __DIR__ . "/../../IMGCompras/imgMarcaDeAgua.png";

    //---------------------------------------------- devuelven arrays de datos obligatorios para cada request
    public static function getPropertiesFull()
    {
        return array(
            'id',
            'id_usuario',
            'articulo',
            'fecha',
            'precio',
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
    public static function getPkCompra()
    {
        return array(
            'id_usuario',
            'articulo',
            'fecha'
        );
    }

    public static function getPropertiesRequired()
    {
        return array(
            'id_usuario',
            'articulo',
            'fecha',
            'precio'
        );
    }

    public static function getPropertiesMod()
    {
        return array(
            'id_usuario',
            'articulo',
            'fecha'
        );
    }

    //---------------------------------------------- metodos
    public function TraerTodos($request, $response, $args)
    {
        $todos = Compra::all();
        $retorno = $response->withJson($todos, 200);
        return $retorno;
    }

    public function TraerUno($request, $response, $args)
    {
        $respuesta = 'datos no existentes';
        $pk = createArray($_GET, self::getPkCompra());
        $dato = buscar(Compra::all(), $pk);
        if ($dato) $respuesta = $dato;
        $retorno = $response->withJson($respuesta, 200);
        return $retorno;
    }

    public function CargarUno($request, $response, $args)
    {

        $parametros = $request->getParsedBody();
        $parametros['id_usuario'] = $request->getAttribute('payload')->id;
        $parametros['id_usuario'] = AutentificadorJWT::ObtenerData($request->getHeader('token')[0])->id;
        $dato = createProperties(new Compra(), $parametros, self::getPropertiesRequired());
        $dato->save();

        $retorno = $response->withJson("id $dato->id cargado", 200);

        if ($retorno) {
            if (isset($_FILES['foto'])) {
                self::subirFoto($dato->id, $dato->articulo, $_FILES['foto']);
            }
        }

        return $retorno;
    }

    public function BorrarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_DELETE);
        $pk = createArray($_DELETE, self::getPk());

        $dato = buscar(Compra::all(), $pk);
        if ($dato) {
            $dato->delete();
            $textoResponse = "id $dato->id borrado";
        }
        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }

    public function ModificarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_PUT);
        $pk = createArray($_PUT, self::getPk());

        $dato = buscar(Compra::all(), $pk);
        if ($dato) {
            foreach (self::getPropertiesMod() as $key) {
                $dato[$key] = $_PUT[$key];
            }
            $dato->save();
            $textoResponse = "se actualizo el id: $dato->id";
        }
        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }

    private static function subirFoto($id, $articulo, $foto)
    {
        $destino =
            self::rutaImgCompras .
            $id .
            $articulo .
            '.' .
            pathinfo($foto['name'], PATHINFO_EXTENSION);

        $destinoBackup = self::rutaBackupImg;

        Upload::upload(
            $foto,
            $destino,
            $destinoBackup,
            array('jpg', 'jpeg', 'png'),
            true, //esImagen 
            self::rutaImgMarcaDeAgua
        );
    }
}
