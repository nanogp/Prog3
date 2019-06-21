<?php

require_once 'clases/Pizza.php';
require_once 'clases/Venta.php';
require_once 'toolbox/Imagenes.php';

class Pizzeria
{   //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const rutaArchivoPizzas = "archivos/Pizza.txt";
    const rutaArchivoVentas = "archivos/Venta.txt";
    const rutaFotoVentas = "archivos/Venta.txt";
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
        $retorno = false;
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        if (Pizza::contiene($lista, array('sabor' => $sabor, 'tipo' => $tipo))) {
            mensaje('Si Hay');
            $retorno = true;
        } elseif (Pizza::contiene($lista, array('sabor' => $sabor))) {
            mensaje('Hay sabor, pero no tipo');
        } elseif (Pizza::contiene($lista, array('tipo' => $tipo))) {
            mensaje('Hay tipo, pero no sabor');
        } else {
            mensaje('No hay tipo ni sabor');
        }
        return $retorno;
    }

    public static function ventaAlta($email, $sabor, $tipo, $cantidad, $foto = null)
    {
        $retorno = false;
        $listaPizzas = Pizza::traerLista(self::rutaArchivoPizzas);
        $listaVentas = Venta::traerLista(self::rutaArchivoVentas);

        $venta = new Venta(Venta::getNextId($listaVentas), $sabor, $tipo, $email, $cantidad);

        if (Pizzeria::pizzaConsultar($sabor, $tipo)) {

            $pizza = Pizza::buscar($listaPizzas, array('sabor' => $sabor, 'tipo' => $tipo));
            if ($pizza->getCantidad() >= $cantidad) {

                $pizza->setCantidad($pizza->getCantidad() - $cantidad);
                ArchivosJSON::guardarTodos(self::rutaArchivoPizzas, $listaPizzas);
                $retorno = $venta->Guardar(self::rutaArchivoVentas);

                if ($foto) {
                    Imagenes::upload(self::rutaFotoVentas . 'nombre', $foto)
                }
            } else {
                mensaje('no hay suficiente stock');
            }
        }
        return $retorno;
    }


    //--------------------------------------------------------------------------------//
}
