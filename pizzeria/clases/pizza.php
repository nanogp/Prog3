<?php

/**
 * 
 */
class Pizza
{

    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const  constructorFromArray = "Pizza::fromArray";
    const  pkCount = 2;
    /* recuento de campos que conforman la pk
    deben estar primeros en los atributos de
    aca abajo para que funcione */
    public $sabor;
    public $tipo;
    public $importe;
    public $stock;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($sabor, $tipo, $importe, $stock)
    {
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->importe = $importe;
        $this->stock = $stock;
    }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    static function fromArray($array)
    {
        return new self(
            $array[0],
            $array[1],
            $array[2],
            rtrim($array[3], PHP_EOL) //saco saltos de linea
        );
    }

    static function traerTodos($nombreArchivo)
    {
        return ArchivosCSV::traerTodos(
            $nombreArchivo,
            Pizza::constructorFromArray
        );
    }

    static function traerUno($nombreArchivo, $pk)
    {
        return ArchivosCSV::traerUno(
            $nombreArchivo,
            Pizza::constructorFromArray,
            $pk
        );
    }

    static function traerVarios($nombreArchivo, $pk)
    {
        return ArchivosCSV::traerVarios(
            $nombreArchivo,
            Pizza::constructorFromArray,
            $pk
        );
    }

    static function agregarUno($nombreArchivo, $pizza)
    {
        return ArchivosCSV::guardarUno(
            $nombreArchivo,
            $pizza
        );
    }

    static function borrarUno($nombreArchivo, $pk)
    {
        return ArchivosCSV::borrarUno(
            $nombreArchivo,
            Pizza::constructorFromArray,
            $pk
        );
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

    function pkToArray()
    {
        $retorno = array();
        for ($i = 0; $i < Pizza::pkCount; $i++) {
            array_push($retorno, $this->toArray()[$i]);
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

    function equals($pizza)
    {
        return $this->equalsSabor($pizza->sabor) &&
            $this->equalsTipo($pizza->sabor);
    }

    function toString()
    {
        return "Sabor: $this->sabor | Tipo: $this->tipo | Importe: $this->importe | Stock: $this->stock<br>";
    }

    function mostrar()
    {
        echo $this->toString();
    }
    //--------------------------------------------------------------------------------//
}
