<?php

require_once "helado.php";
//require_once "ventas.php";
require_once "./toolbox/archivosCSV.php";
require_once "./toolbox/mensajes.php";

/**
 * 
 */
class Heladeria
{

    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const archivoStockCSV = "./archivos/helados.csv";
    const archivoVentasCSV = "./archivos/ventas.csv";
    const formatoFecha = "Y-m-d H:i";
    private $nombre;
    private $fhInicio; //fecha-hora

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($nombre)
    {
        $this->nombre = $nombre;
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
        return Helado::traerUno(self::archivoStockCSV, $pk);
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

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* VENTAS */
    static function getVentas()
    {
        return ArchivosCSV::traerTodos(self::archivoVentasCSV, Venta::constructorFromArray);
    }

    static function getFhInicio()
    {
        return $this->fhInicio;
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
            echo "listado vacio<br>";
        } else {
            foreach ($listado as $obj) {
                /* requiere que el objeto tenga su metodo mostrar() */
                $obj->mostrar();
            }
        }
    }


    //--------------------------------------------------------------------------------//
    /* GESTION */
    static function altaHelado($sabor, $tipo, $precio, $cantidad)
    {
        if (in_array($tipo, Helado::getTiposValidos())) {
            $helado = new Helado($sabor, $tipo, $precio, $cantidad);

            $listado = self::getStock();
            $existente = Helado::contains($listado, $helado->pkToArray());

            if ($existente === null) {
                Helado::agregarUno(Heladeria::archivoStockCSV, $helado);
                mensaje('se hizo el alta ingresada');
            } else {
                mensaje('se agrego stock ingresado al helado existente');
                $existente->cantidad += $cantidad;
                $existente->mostrar();
                Heladeria::putStock($listado);
            }
        } else {
            mensaje('tipo de helado invalido');
        }
    }
    //--------------------------------------------------------------------------------//
}
