<?php

namespace App\Models\ORM;

use App\Models\ORM\Compra;
use App\Models\ORM\Usuario;
use App\Models\API\IApiController;
use App\Models\API\AutentificadorJWT;

include_once __DIR__ . '/Usuario.php';
include_once __DIR__ . '/../API/IApiController.php';
include_once __DIR__ . '/../API/AutentificadorJWT.php';
include_once __DIR__ . '/../../common.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use MWparaAutentificar;
use phpDocumentor\Reflection\Types\String_;

class CompraController implements IApiController
{
    const rutaImgCompras = __DIR__ . "/../../../../public/IMGCompras/";
    const rutaBackupImg = __DIR__ . "/../../../../public/IMGCompras/backup/";
    const rutaImgMarcaDeAgua = __DIR__ . "/../../../../public/IMGCompras/imgMarcaDeAgua.png";

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
            'articulo',
            'precio'
        );
    }

    public static function getPropertiesTabla()
    {
        return array(
            'id',
            'id_usuario',
            'articulo',
            'fecha',
            'precio'
        );
    }

    //---------------------------------------------- metodos
    public function TraerTodos($request, $response, $args)
    {
        $todos = Compra::all();
        $retorno = $response->withJson($todos, 200);
        return $retorno;
    }

    public function TraerPorUsuario($request, $response, $args)
    {
        $respuesta = 'no existe el usuario';
        $parametros['nombre'] = $request->getQueryParam('nombre');
        $usuario = buscarPorBase(Usuario::class, $parametros);

        if ($usuario) {
            $respuesta = 'no hay datos para ese usuario';
            $datos = buscarPorBaseTodos(Compra::class, array('id_usuario' => $usuario->id));

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
        }
        return $respuesta;
    }


    public function TraerTodosConFoto($request, $response, $args)
    {
        $todos = Compra::all();

        $strHtml = "<table border='1' style='border-collapse: collapse'>";
        foreach ($todos as $compra) {
            foreach (self::getPropertiesTabla() as $key) {
                $strHtml .= "<th>" . strtoupper($key) . "</th>";
            }
            $strHtml .= "<th>FOTO</th>";
            break;
        }

        $strHtml .= "<tbody>";
        foreach ($todos as $compra) {
            $strHtml .= "<tr>";
            foreach (self::getPropertiesTabla() as $key) {
                $strHtml .= "<td height=120>$compra[$key]</td>";
            }
            $rutaOrigen =  self::rutaImgCompras . $compra->id .  $compra->articulo . ".png";
            if (file_exists($rutaOrigen)) {
                $rutaMostrar = $request->getUri()->getBasePath() . "/IMGCompras/"  . $compra->id .  $compra->articulo . ".png";
                $strHtml .= "<td><img src=$rutaMostrar height=120 width=120></img></td>";
            } else {
                $strHtml .= "<td>SIN FOTO</td>";
            }
            $strHtml .= "</tr>";
        }
        $strHtml .= "</tbody>";

        // $retorno = $response->with($strHtml, 200);
        return $strHtml;
    }

    public function TraerUno($request, $response, $args)
    {
        $respuesta = 'datos no existentes';
        // $pk = createArray($_GET, self::getPkCompra());
        // $dato = buscar(Compra::all(), $pk);
        $pk = createArray($request->getQueryParam(self::getPk()[0]), self::getPk());
        $dato = buscarPorBase(Compra::class, $pk);
        if ($dato) $respuesta = $dato;
        $retorno = $response->withJson($respuesta, 200);
        return $retorno;
    }

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $parametros['id_usuario'] = $request->getAttribute('payload')->id;
        //$parametros['id_usuario'] = AutentificadorJWT::ObtenerData($request->getHeader('token')[0])->id;
        $dato = createProperties(new Compra(), $parametros, self::getPropertiesRequired());
        $dato->save();

        $retorno = $response->withJson("id $dato->id cargado", 200);

        if ($retorno && isset($_FILES['foto'])) self::subirFoto($dato->id, $dato->articulo, $_FILES['foto']);

        return $retorno;
    }

    public function BorrarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_DELETE);
        $pk = createArray($_DELETE, self::getPk());

        $compras = buscar(Compra::all(), $pk);
        if ($compras) {
            foreach ($compras as $compra) {
                $compra->delete();
                $rutaOrigen = self::rutaImgCompras . $compra->id . $compra->articulo . ".png";
                if (file_exists($rutaOrigen)) {
                    $rutaDestino = self::rutaBackupImg;
                    Archivos::moverABackup($rutaOrigen, $rutaDestino);
                }
            }
        }

        $retorno = $response->withJson($textoResponse, 200);
        return $retorno;
    }

    public function BorrarPorUsuario($id_usuario)
    {
        $pk['id_usuario'] = $id_usuario;
        Compra::where($pk)->delete();
    }

    public function ModificarUno($request, $response, $args)
    {
        $textoResponse = 'no se encontro el id';
        parse_str(file_get_contents("php://input"), $_PUT);
        $pk = createArray($_PUT, self::getPk());

        $dato = buscarPorBase(Compra::class, $pk);
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
