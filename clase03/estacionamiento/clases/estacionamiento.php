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
    private $fhActual; //fecha-hora

    function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->listado = array();
        $this->fhActual = date(Estacionamiento::formatoFecha);
    }

    function getListado()
    {
        return $this->listado;
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
        //Archivos::guardarListadoCSV( Estacionamiento::nombreArchivoCSV, $this->listado);
        Archivos::guardarListadoCSV("archivos/prueba.csv", $this->getListado());
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
