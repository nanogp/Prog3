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

    static function leer()
    {
        $archivo = fopen("./vehiculos.txt", "r");
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

    function mostrar()
    {
        echo "Patente: $this->patente | Ingreso: $this->ingreso | Importe: $this->importe<br>";
    }
}
