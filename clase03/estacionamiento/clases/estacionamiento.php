<?php

require_once "clases/archivos.php";

/**
 * 
 */
class Estacionamiento
{
    const nombreArchivoEstacionados = "archivos/estacionados.txt";
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

    function leerCSV()
    {
        $this->listado = Archivos::leerCSV(Estacionamiento::nombreArchivoEstacionados, Vehiculo::constructorFromArray);
    }

    function guardarCSV($vehiculo)
    {
        Archivos::guardarCSV(Estacionamiento::nombreArchivoEstacionados, $vehiculo->toArray());
    }

    function mostrar()
    {
        if(!$this->listado)
        {
            echo "listado vacio<br>";
        }
        else
        {
            foreach ($this->listado as $v)
            {
                $v->mostrar();
            }
        }

    }

}

?>