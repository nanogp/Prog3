<?php

require_once 'toolbox/ArchivosJSON.php';

class Pizza
{
    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const nombreConstructorJSON = 'Pizza::fromAssociativeArray';
    private $id;
    private $tipo;
    private $sabor;
    private $precio;
    private $cantidad;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($id, $sabor, $tipo,  $precio, $cantidad = 0)
    {
        $this->id = $id;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    //--------------------------------------------------------------------------------//
    /* GET SET */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSabor()
    {
        return $this->sabor;
    }

    public function setSabor($sabor)
    {
        $this->sabor = $sabor;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    //--------------------------------------------------------------------------------//



    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    public static function fromAssociativeArray($array)
    {
        return new self($array['id'], $array['sabor'], $array['tipo'], $array['precio'], $array['cantidad']);
    }

    public static function traerLista($rutaArchivo)
    {
        return ArchivosJSON::traerTodos($rutaArchivo, self::nombreConstructorJSON);
    }

    public static function getNextId($lista)
    {
        $maxID = 0; //no se usa id cero
        foreach ($lista as $pizza) {
            if ($pizza->getID() > $maxID) {
                $maxID = $pizza->getId();
            }
        }
        return $maxID + 1;
    }

    public static function contiene($lista, $pk)
    {
        return ArchivosJSON::contiene($lista, $pk);
    }

    public static function buscar($lista, $pk)
    {
        return ArchivosJSON::buscar($lista, $pk);
    }

    public static function mostrarLista($lista)
    {
        foreach ($lista as $pizza) {
            $pizza->mostrar();
        }
    }

    public static function modificarUno($rutaArchivo, $pizza)
    {
        return ArchivosJSON::modificarUno(
            $rutaArchivo,
            self::nombreConstructorJSON,
            $pizza->pkToAssociativeArray(),
            array('precio' => $pizza->getPrecio()),
            array('cantidad' => $pizza->getCantidad())
        );
    }

    public static function borrarUno($rutaArchivo, $pk)
    {
        return ArchivosJSON::borrarUno(
            $rutaArchivo,
            self::nombreConstructorJSON,
            $pk
        );
    }


    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE INSTANCIA */
    public function toString()
    {
        return "Id: $this->id | Sabor: $this->sabor | Tipo: $this->tipo | Precio: $this->precio | Cantidad: $this->cantidad<br>";
    }

    public function mostrar()
    {
        echo $this->toString();
    }

    public function toAssociativeArray()
    {
        return array('id' => $this->getId(), 'sabor' => $this->getSabor(), 'tipo' => $this->getTipo(), 'precio' => $this->getPrecio(), 'cantidad' => $this->getCantidad());
    }

    public function pkToAssociativeArray()
    {
        return array('sabor' => $this->getSabor(), 'tipo' => $this->getTipo());
    }

    public function guardar($rutaArchivo)
    {
        return ArchivosJSON::guardarUno($rutaArchivo, $this->toAssociativeArray());
    }

    //--------------------------------------------------------------------------------//
}
