<?php

require_once 'clases/Pizza.php';

class Pizzeria
{   //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const rutaArchivoPizzas = "archivos/Pizza.txt";
    const rutaArchivoVentas = "archivos/Venta.txt";
    const rutaImgPizzas =  "archivos/ImagenesDePizzas/";

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    private function __construct()
    { }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */
    public static function pizzaAlta($sabor, $tipo, $precio, $cantidad)
    {
        $retorno = false;
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        $pizza = new Pizza(Pizza::getNextId($lista), $sabor, $tipo, $precio, $cantidad);
        if (Pizza::contiene($lista, $pizza->pkToAssociativeArray())) {
            mensaje('pizza ya existe'); //puede agregar stock
        } else {
            $retorno = $pizza->Guardar(self::rutaArchivoPizzas);
        }
        return $retorno;
    }

    public static function pizzaConsultar($sabor, $tipo)
    {
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        if (Pizza::contiene($lista, array('sabor' => $sabor, 'tipo' => $tipo))) {
            mensaje('Si Hay');
        } elseif (Pizza::contiene($lista, array('sabor' => $sabor))) {
            mensaje('Hay sabor, pero no tipo');
        } elseif (Pizza::contiene($lista, array('tipo' => $tipo))) {
            mensaje('Hay tipo, pero no sabor');
        } else {
            mensaje('No hay tipo ni sabor');
        }
    }

    public static function ventaAlta($email, $sabor, $tipo, $cantidad)
    {
        # code...
    }


    //--------------------------------------------------------------------------------//
}
