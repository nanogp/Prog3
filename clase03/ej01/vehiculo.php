<?php

class vehiculo
{
    private $patente;
    private $ingreso;
    private $importe;

    function __construct($patente, $ingreso, $importe)
    {
        $this->patente = $patente;
        $this->ingreso = $ingreso;
        $this->importe = $importe;
    }

    static function leer($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo, "r");
        $retorno = array();

        while (!feof($archivo)) {

            $linea = fgets($archivo);
            $arrayDeDatos = explode(",", $linea);
            $vehiculo = new vehiculo($arrayDeDatos[0], $arrayDeDatos[1], $arrayDeDatos[2]);
            array_push($retorno, $vehiculo);
        }

        fclose($archivo);

        return $retorno;
    }

    function guardar($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo, "a+");
        $linea = implode(",", $this->toArray());
        fputs($archivo, $linea.PHP_EOL);
        fclose($archivo);
    }

    function mostrar()
    {
        echo "Patente: $this->patente | Ingreso: $this->ingreso | Importe: $this->importe<br>";
    }

    function toArray()
    {
        return array($this->patente, $this->ingreso, $this->importe);
    }
}
