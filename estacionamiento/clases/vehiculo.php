<?php

/**
 * 
 */
class Vehiculo
{
    const constructorFromArray = "Vehiculo::fromArray";
    public $patente;
    public $fechaHoraIngreso;
    public $importe;

    function __construct($patente, $fechaHoraIngreso, $importe)
    {
        $this->patente = $patente;
        $this->fechaHoraIngreso = $fechaHoraIngreso;
        $this->importe = $importe;
    }

    static function fromArray($array)
    {
        return new self($array[0], $array[1], rtrim($array[2], PHP_EOL));
    }

    function toArray()
    {
        return array($this->patente, $this->fechaHoraIngreso, $this->importe);
    }

    function equalsPatente($patente)
    {
        return $this->patente === $patente;
    }

    function equalsVehiculo($vehiculo)
    {
        return $this->equalsPatente($vehiculo->patente);
    }

    function toString()
    {
        return "Patente: $this->patente | Ingreso: $this->fechaHoraIngreso | Importe: $this->importe<br>";
    }

    static function validarPatente($patente)
    {
        return preg_match("/^[a-z]{3}[0-9]{3}$/i", $patente)
            || preg_match("/^[a-z]{2}[0-9]{3}[a-z]{2}$/i", $patente);
    }

    function mostrar()
    {
        echo $this->toString();
    }
}
