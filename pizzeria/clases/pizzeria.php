<?php

require_once "../toolbox/archivos.php";
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
    private $listadoStock;
    private $listadoVentas;
    private $fhInicio; //fecha-hora

    function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->listadoStock = array();
        $this->listadoVentas = array();
        $this->fhInicio = date(Pizzeria::formatoFecha);
    }

    function getListadoStock()
    {
        if (empty($this->listadoStock)) {
            $this->leerCSV();
        }
        return $this->listadoStock;
    }

    function getListadoVentas()
    {
        if (empty($this->listadoVentas)) {
            $this->leerCSV();
        }
        return $this->listadoVentas;
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
            mensajeError("patente no valida");
        }
    }

    function pushListado($vehiculo)
    {
        array_push($this->listado, $vehiculo);
        $this->guardarCSV($vehiculo);
    }

    function leerCSV()
    {
        $this->listado = Archivos::leerCSV(Pizzeria::archivoStockCSV, Pizza::constructorFromArray);
    }

    function guardarCSV($vehiculo)
    {
        Archivos::guardarCSV(Pizzeria::archivoStockCSV, $vehiculo->toArray());
    }

    function guardarListadoCSV()
    {
        Archivos::guardarListadoCSV(Pizzeria::archivoStockCSV, $this->listado);
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

    function mostrarListado()
    {
        if (!$this->listado) {
            echo "listado vacio<br>";
        } else {
            foreach ($this->listado as $vehiculo) {
                $vehiculo->mostrar();
            }
        }
    }
}
