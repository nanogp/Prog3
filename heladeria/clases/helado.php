<?php

require_once "./toolbox/archivosCSV.php";

/**
 * 
 */
class Helado
{

    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const  constructorFromArray = "Helado::fromArray";
    const  pkCount = 2;
    /* recuento de campos que conforman la pk
    deben estar primeros en los atributos de
    aca abajo para que funcione */
    public $sabor;
    public $tipo;
    public $precio;
    public $cantidad;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($sabor, $tipo, $precio, $cantidad = 0)
    {
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    static function contains($listado, $pk)
    {
        $retorno = null;
        foreach ($listado as $helado) {
            if (Archivos::compararPk($helado->toArray(), $pk)) {
                $retorno = $helado;
                break;
            }
        }
        return $retorno;
    }

    static function getTiposValidos()
    {
        return array('crema', 'agua');
    }

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
            self::constructorFromArray
        );
    }

    static function traerUno($nombreArchivo, $pk)
    {
        return ArchivosCSV::traerUno(
            $nombreArchivo,
            self::constructorFromArray,
            $pk
        );
    }

    static function traerVarios($nombreArchivo, $pk)
    {
        return ArchivosCSV::traerVarios(
            $nombreArchivo,
            self::constructorFromArray,
            $pk
        );
    }

    static function agregarUno($nombreArchivo, $Helado)
    {
        return ArchivosCSV::guardarUno(
            $nombreArchivo,
            $Helado
        );
    }

    static function borrarUno($nombreArchivo, $pk)
    {
        return ArchivosCSV::borrarUno(
            $nombreArchivo,
            self::constructorFromArray,
            $pk
        );
    }


    static function modificarUno($nombreArchivo, $Helado)
    {
        return ArchivosCSV::modificarUno(
            $nombreArchivo,
            self::constructorFromArray,
            $Helado
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
        for ($i = 0; $i < self::pkCount; $i++) {
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

    function equals($Helado)
    {
        return $this->equalsSabor($Helado->sabor) &&
            $this->equalsTipo($Helado->tipo);
    }

    function toString()
    {
        return "Sabor: $this->sabor | Tipo: $this->tipo | Precio: $this->precio | Cantidad KGs: $this->cantidad<br>";
    }

    function mostrar()
    {
        echo $this->toString();
    }

    //--------------------------------------------------------------------------------//
}
