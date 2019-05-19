<?php

require_once "clases/archivos.php";

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

    function addVehiculo($patente)
    {
        $this->putListado(new vehiculo($patente, $this->getFHActual(), "0"));
    }

    function putListado($vehiculo)
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

    function mostrar()
    {
        if (!$this->listado) {
            echo "listado vacio<br>";
        } else {
            foreach ($this->listado as $v) {
                $v->mostrar();
            }
        }
    }
}
