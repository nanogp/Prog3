<?php

require_once 'toolbox/ArchivosJSON.php';

class Empleado
{
    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const nombreConstructorJSON = 'Empleado::fromAssociativeArray';
    private $id;
    private $tipo;
    private $alias;
    private $email;
    private $edad;
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($id, $alias, $tipo,  $email, $edad)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->tipo = $tipo;
        $this->email = $email;
        $this->edad = $edad;
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

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function setEdad($edad)
    {
        $this->edad = $edad;
    }
    //--------------------------------------------------------------------------------//



    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    public static function fromAssociativeArray($array)
    {
        return new self($array['id'], $array['alias'], $array['tipo'], $array['email'], $array['edad']);
    }

    public static function traerLista($rutaArchivo)
    {
        return ArchivosJSON::traerTodos($rutaArchivo, self::nombreConstructorJSON);
    }

    public static function getNextId($lista)
    {
        $maxID = 0; //no se usa id cero
        foreach ($lista as $empleado) {
            if ($empleado->getID() > $maxID) {
                $maxID = $empleado->getId();
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
        foreach ($lista as $empleado) {
            $empleado->mostrar();
        }
    }


    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE INSTANCIA */
    public function toString()
    {
        return "Id: $this->id | Email: $this->email | Alias: $this->alias | Tipo: $this->tipo  | Edad: $this->edad";
    }

    public function mostrar()
    {
        echo $this->toString() . "<br>";
    }

    public function toAssociativeArray()
    {
        return array('id' => $this->getId(), 'alias' => $this->getAlias(), 'tipo' => $this->getTipo(), 'email' => $this->getEmail(), 'edad' => $this->getEdad());
    }

    public function pkToAssociativeArray()
    {
        return array('alias' => $this->getAlias(), 'tipo' => $this->getTipo(), 'email' => $this->getEmail());
    }

    public function guardar($rutaArchivo)
    {
        return ArchivosJSON::guardarUno($rutaArchivo, $this->toAssociativeArray());
    }

    //--------------------------------------------------------------------------------//
}
