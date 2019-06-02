<?php

require_once "../toolbox/archivos.php";
require_once "../toolbox/mensajes.php";

/**
 * 
 */
class Estacionamiento
{
    const nombreArchivoCSV = "archivos/estacionados.csv";
    const formatoFecha = "Y-m-d H:i";
    private $nombre;
    private $listado;
    private $fhInicio; //fecha-hora

    function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->listado = array();
        $this->fhInicio = date(Estacionamiento::formatoFecha);
    }

    function getListado()
    {
        if (empty($this->listado)) {
            $this->leerCSV();
        }
        return $this->listado;
    }

    function getFhInicio()
    {
        return $this->fhInicio;
    }

    function getFHActual()
    {
        return date(Estacionamiento::formatoFecha);
    }

    function getVehiculo($patente)
    {

        return $this->listado();
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
        $this->listado = Archivos::leerCSV(Estacionamiento::nombreArchivoCSV, Vehiculo::constructorFromArray);
    }

    function guardarCSV($vehiculo)
    {
        Archivos::guardarCSV(Estacionamiento::nombreArchivoCSV, $vehiculo->toArray());
    }

    function guardarListadoCSV()
    {
        Archivos::guardarListadoCSV(Estacionamiento::nombreArchivoCSV, $this->listado);
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
