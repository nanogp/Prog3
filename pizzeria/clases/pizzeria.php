<?php

require_once "../toolbox/archivosCSV.php";
require_once "../toolbox/mensajes.php";

/**
 * 
 */
class Pizzeria
{
    const archivoStockCSV = "archivos/stock.csv";
    const archivoStockJSON = "archivos/stock.json";
    const archivoVentasCSV = "archivos/ventas.csv";
    const archivoVentasJSON = "archivos/ventas.json";
    const formatoFecha = "Y-m-d H:i";
    private $nombre;
    private $fhInicio; //fecha-hora

    function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->fhInicio = date(Pizzeria::formatoFecha);
    }

    function getStock()
    {
        return ArchivosCSV::traerTodos(Pizzeria::archivoStockCSV, Pizza::constructorFromArray);
    }

    function getUnoStock($pk)
    {
        return ArchivosCSV::traerUno(
            Pizzeria::archivoStockCSV,
            Pizza::constructorFromArray,
            $pk
        );
    }

    function getVariosStock($pk)
    {
        return ArchivosCSV::traerVarios(
            Pizzeria::archivoStockCSV,
            Pizza::constructorFromArray,
            $pk
        );
    }

    function getVentas()
    {
        return ArchivosCSV::traerTodos(Pizzeria::archivoVentasCSV, Venta::constructorFromArray);
    }

    function getFhInicio()
    {
        return $this->fhInicio;
    }

    function getFHActual()
    {
        return date(Pizzeria::formatoFecha);
    }

    function getPizza($sabor, $tipo)
    {
        return $this->listadoStock();
    }

    function pushVehiculo($patente)
    {
        if (Vehiculo::validarPatente($patente)) {
            $this->pushListado(new vehiculo($patente, $this->getFHActual(), "0"));
        } else {
            mensaje("patente no valida");
        }
    }

    function pushListado($vehiculo)
    {
        array_push($this->listado, $vehiculo);
        $this->guardarCSV($vehiculo);
    }

    function guardarCSV($vehiculo)
    {
        ArchivosCSV::guardarCSV(Pizzeria::archivoStockCSV, $vehiculo->toArray());
    }

    function guardarListadoCSV()
    {
        ArchivosCSV::guardarListadoCSV(Pizzeria::archivoStockCSV, $this->listado);
    }

    function existsVehiculo($patente)
    {
        $retorno = false;
        if (empty($this->listado)) {
            $this->leerCSV();
        }

        foreach ($this->listado as $vehiculo) {
            if ($vehiculo->equalsPatente($patente)) {
                $retorno = true;
                break;
            }
        }

        return $retorno;
    }

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
