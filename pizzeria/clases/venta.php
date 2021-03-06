<?php

/**
 * 
 */
class Venta
{
    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const constructorFromArray = "Venta::fromArray";
    public $sabor;
    public $tipo;
    public $cliente;
    public $importe;
    public $cantidad;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($sabor, $tipo, $cliente, $importe, $cantidad)
    {
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cliente = $cliente;
        $this->importe = $importe;
        $this->cantidad = $cantidad;
    }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    static function fromArray($array)
    {
        return new self($array[0], $array[1], $array[2], $array[3], rtrim($array[4], PHP_EOL));
    }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE INSTANCIA */
    function toArray()
    {
        $retorno = array();
        foreach ($this as $key => $value) {
            array_push($retorno, $value);
        }
        return $retorno;
    }

    function equalsSabor($sabor)
    {
        return $this->sabor === $sabor;
    }

    function equalsTipo($tipo)
    {
        return $this->tipo === $tipo;
    }

    function equalsCliente($cliente)
    {
        return $this->cliente === $cliente;
    }

    function equals($venta)
    {
        return $this->equalsSabor($venta->sabor)
            && $this->equalsTipo($venta->tipo)
            && $this->equalsCliente($venta->cliente);
    }

    function toString()
    {
        return "Sabor: $this->sabor | Tipo: $this->tipo | Importe: $this->importe | cantidad: $this->cantidad<br>";
    }

    static function validarVenta($sabor)
    {
        return preg_match("/^[a-z]{3}[0-9]{3}$/i", $sabor)
            || preg_match("/^[a-z]{2}[0-9]{3}[a-z]{2}$/i", $sabor);
    }

    function mostrar()
    {
        echo $this->toString();
    }
    //--------------------------------------------------------------------------------//
}
