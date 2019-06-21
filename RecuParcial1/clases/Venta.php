<?php

require_once 'toolbox/ArchivosJSON.php';

class Venta
{
    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const nombreConstructorJSON = 'Venta::fromAssociativeArray';
    private $id;
    private $tipo;
    private $sabor;
    private $email;
    private $cantidad;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($id, $sabor, $tipo,  $email, $cantidad)
    {
        $this->id = $id;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->email = $email;
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

    public function getemail()
    {
        return $this->email;
    }

    public function setemail($email)
    {
        $this->email = $email;
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
        return new self($array['id'], $array['sabor'], $array['tipo'], $array['email'], $array['cantidad']);
    }

    public static function traerLista($rutaArchivo)
    {
        return ArchivosJSON::traerTodos($rutaArchivo, self::nombreConstructorJSON);
    }

    public static function getNextId($lista)
    {
        $maxID = 0; //no se usa id cero
        foreach ($lista as $venta) {
            if ($venta->getID() > $maxID) {
                $maxID = $venta->getId();
            }
        }
        return $maxID + 1;
    }

    public static function contiene($lista, $pk)
    {
        return ArchivosJSON::contiene($lista, $pk);
    }

    public static function mostrarLista($lista)
    {
        foreach ($lista as $venta) {
            $venta->mostrar();
        }
    }


    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE INSTANCIA */
    public function toString()
    {
        return "Id: $this->id | Email: $this->email | Sabor: $this->sabor | Tipo: $this->tipo  | Cantidad: $this->cantidad<br>";
    }

    public function mostrar()
    {
        echo $this->toString();
    }

    public function toAssociativeArray()
    {
        return array('id' => $this->getId(), 'sabor' => $this->getSabor(), 'tipo' => $this->getTipo(), 'email' => $this->getEmail(), 'cantidad' => $this->getCantidad());
    }

    public function pkToAssociativeArray()
    {
        return array('sabor' => $this->getSabor(), 'tipo' => $this->getTipo(), 'email' => $this->getEmail());
    }

    public function guardar($rutaArchivo)
    {
        return ArchivosJSON::guardarUno($rutaArchivo, $this->toAssociativeArray());
    }

    //--------------------------------------------------------------------------------//
}
