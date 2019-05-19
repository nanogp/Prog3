<?php

/**
 * 
 */
class Vehiculo
{
    const constructorFromArray = "Vehiculo::vehiculoFromArray";
    private $patente;
    private $fechaHoraIngreso;
    private $importe;

    function __construct($patente, $fechaHoraIngreso, $importe)
    {
        $this->patente = $patente;
        $this->fechaHoraIngreso = $fechaHoraIngreso;
        $this->importe = $importe;
    }

    static function vehiculoFromArray($array)
    {
        return new self($array[0], $array[1], rtrim($array[2], PHP_EOL));
    }

    function mostrar()
    {
        echo "Patente: $this->patente | Ingreso: $this->fechaHoraIngreso | Importe: $this->importe<br>";
    }

    function toArray()
    {
        return array($this->patente, $this->fechaHoraIngreso, $this->importe);
    }
}
