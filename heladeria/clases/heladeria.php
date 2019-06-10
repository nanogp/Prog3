<?php

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
    function getStock()
    {
        return Helado::traerTodos(self::archivoStockCSV);
    }

    function getUnoStock($pk)
    {
        return Helado::traerUno(self::archivoStockCSV, $pk);
    }

    function getVariosStock($pk)
    {
        return ArchivosCSV::traerVarios(
            self::archivoStockCSV,
            Helado::constructorFromArray,
            $pk
        );
    }

    function altaStock($helado)
    {
        Helado::agregarUno(
            self::archivoStockCSV,
            $helado
        );
    }

    function borraStock($pk)
    {
        Helado::borrarUno(
            self::archivoStockCSV,
            $pk
        );
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* VENTAS */
    function getVentas()
    {
        return ArchivosCSV::traerTodos(self::archivoVentasCSV, Venta::constructorFromArray);
    }

    function getFhInicio()
    {
        return $this->fhInicio;
    }

    function getFHActual()
    {
        return date(self::formatoFecha);
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* OTROS */
    function mostrarListado($listado)
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
}
