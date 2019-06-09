<?php

/**
 * 
 */
class Pizza
{
    const constructorFromArray = "Pizza::fromArray";
    public $sabor;
    public $tipo;
    public $importe;
    public $stock;

    function __construct($sabor, $tipo, $importe, $stock)
    {
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->importe = $importe;
        $this->stock = $stock;
    }

    static function fromArray($array)
    {
        return new self($array[0], $array[1], $array[2], rtrim($array[3], PHP_EOL));
    }

    function toArray()
    {
        return array($this->sabor, $this->tipo, $this->importe, $this->stock);
    }

    function equalsSabor($sabor)
    {
        return $this->sabor === $sabor;
    }

    function equalsTipo($tipo)
    {
        return $this->tipo === $tipo;
    }

    function equals($pizza)
    {
        return $this->equalsSabor($pizza->sabor) &&
            $this->equalsTipo($pizza->sabor);
    }

    function toString()
    {
        return "Sabor: $this->sabor | Tipo: $this->tipo | Importe: $this->importe | Stock: $this->stock<br>";
    }

    static function validarsabor($sabor)
    {
        return preg_match("/^[a-z]{3}[0-9]{3}$/i", $sabor)
            || preg_match("/^[a-z]{2}[0-9]{3}[a-z]{2}$/i", $sabor);
    }

    function mostrar()
    {
        echo $this->toString();
    }
}
