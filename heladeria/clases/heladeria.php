<?php

require_once "helado.php";
//require_once "ventas.php";
require_once "./toolbox/archivosCSV.php";
require_once "./toolbox/mensajes.php";
require_once "./toolbox/upload.php";


/**
 * 
 */
class Heladeria
{

    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const archivoStockCSV = "./archivos/helados.csv";
    const archivoVentasCSV = "./archivos/ventas.csv";
    const rutaFotosHelados = "./fotosHelados/";
    const rutaFotosVentas = "./fotosVentas/";
    const formatoFecha = " Y -m - d H : i";
    private  $nombre;
    private  $fhInicio; //fecha-hora

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($nombre)
    {
        $this->nombre =  $nombre;
        $this->fhInicio = date(self::formatoFecha);
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* STOCK */
    static function getStock()
    {
        return Helado::traerTodos(self::archivoStockCSV);
    }

    static function getUnoStock($pk)
    {
        return Helado::traerUno(self::archivoStockCSV,  $pk);
    }

    static function getVariosStock($pk)
    {
        return ArchivosCSV::traerVarios(
            self::archivoStockCSV,
            Helado::constructorFromArray,
            $pk
        );
    }

    static function putStock($listado)
    {
        ArchivosCSV::guardarTodos(
            self::archivoStockCSV,
            $listado
        );
    }


    static function altaStock($helado)
    {
        Helado::agregarUno(
            self::archivoStockCSV,
            $helado
        );
    }

    static function borraStock($pk)
    {
        Helado::borrarUno(
            self::archivoStockCSV,
            $pk
        );
    }

    static function altaHelado($sabor,  $tipo,  $precio,  $cantidad)
    {
        if (in_array($tipo, Helado::getTiposValidos())) {
            $helado = new Helado($sabor,  $tipo,  $precio,  $cantidad);

            $listado = self::getStock();
            $existente = Helado::contains($listado,  $helado->pkToArray());

            if ($existente === null) {
                Helado::agregarUno(Heladeria::archivoStockCSV,  $helado);
                mensaje('se hizo el alta ingresada');
            } else {
                mensaje('se agrego stock ingresado al helado existente');
                $existente->cantidad +=  $cantidad;
                $existente->mostrar();
                Heladeria::putStock($listado);
            }
        } else {
            mensaje('tipo de helado invalido');
        }
    }

    static function altaHeladoConFoto($sabor,  $tipo,  $precio,  $cantidad,  $foto)
    {
        if (in_array($tipo, Helado::getTiposValidos())) {
            $helado = new Helado($sabor,  $tipo,  $precio,  $cantidad);

            $listado = self::getStock();
            $existente = Helado::contains($listado,  $helado->pkToArray());

            if ($existente === null) {
                Helado::agregarUno(Heladeria::archivoStockCSV,  $helado);
                Upload::cargarImagenPorNombre($foto, ($sabor .  $tipo), self::rutaFotosHelados);
                mensaje('se hizo el alta ingresada');
            } else {
                mensaje('se agrego stock ingresado al helado existente');
                $existente->cantidad +=  $cantidad;
                $existente->mostrar();
                Heladeria::putStock($listado);
            }
        } else {
            mensaje('tipo de helado invalido');
        }
    }

    static function modificacionHelado($sabor,  $tipo,  $precio,  $cantidad)
    {
        if (
            in_array($tipo, Helado::getTiposValidos()) &&
            $precio >= 0
        ) {

            $listado = self::getStock();
            $existente = Helado::contains($listado, array($sabor,  $tipo));

            if ($existente === null) {
                mensaje('no existe el helado ingresado');
                //se pude llamar al alta
            } else {
                if ($precio != 0) {
                    $existente->precio =  $precio;
                }
                if ($cantidad != 0) {
                    $existente->cantidad +=  $cantidad;
                }
                $existente->mostrar();
                Heladeria::putStock($listado);
                mensaje('se modifico el helado ingresado');
            }
        } else {
            mensaje('datos ingresados invalidos');
        }
    }

    static function borrarHelado($sabor,  $tipo)
    {
        if (
            in_array($tipo, Helado::getTiposValidos())
        ) {
            $pk = array($sabor,  $tipo);
            $listado = Helado::traerTodos(Heladeria::archivoStockCSV);

            if (!Archivos::contieneListado($listado,  $pk)) {
                mensaje('no se encontro el registro buscado');
            } else {
                Helado::borrarUno(Heladeria::archivoStockCSV,  $pk);
                mensaje('se borro el registro ingresado');
            }
        } else {
            mensaje('tipo ingresado invalido');
        }
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* VENTAS */
    static function getVentas()
    {
        return ArchivosCSV::traerTodos(self::archivoVentasCSV, Venta::constructorFromArray);
    }

    static function getFhInicio()
    {
        return  $this->fhInicio;
    }

    static function getFHActual()
    {
        return date(self::formatoFecha);
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* OTROS */
    static function mostrarListado($listado)
    {
        if (!$listado) {
            echo   "no hay del tipo/sabor elegido <br>";
        } else {

            echo  "<table>";
            $aux =
                "<tr>
            <th> sabor </th>
            <th> tipo </th>
            <th> precio </th>
            <th> cantidad </th>
            <th> foto </th>
            </tr>";
            echo $aux;

            foreach ($listado as  $helado) {
                //    /* requiere que el objeto tenga su metodo mostrar() */
                //    $obj->mostrar();

                $img = "./fotosHelados/" . $helado->sabor . $helado->tipo . ".png";
                $aux =
                    "<tr>
                    <td>" . $helado->sabor . "</td>
                    <td>" . $helado->tipo . "</td>
                    <td>" . $helado->precio . "</td>
                    <td>" . $helado->cantidad . "</td>
                    <td><img src=" . $img . " alt=" . " border=3 height=100px width=100px><img></td>
                </tr>";
                echo $aux;
            }
            echo "</table>";
        }
    }


    //--------------------------------------------------------------------------------//

}
