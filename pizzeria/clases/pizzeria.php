<?php

require_once "../toolbox/archivosCSV.php";
require_once "../toolbox/mensajes.php";

/**
 * 
 */
class Pizzeria
{

    //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const archivoStockCSV = "archivos/stock.csv";
    const archivoStockJSON = "archivos/stock.json";
    const archivoVentasCSV = "archivos/ventas.csv";
    const archivoVentasJSON = "archivos/ventas.json";
    const formatoFecha = "Y-m-d H:i";
    private $nombre;
    private $fhInicio; //fecha-hora

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->fhInicio = date(Pizzeria::formatoFecha);
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* STOCK */
    function getStock()
    {
        return Pizza::traerTodos(Pizzeria::archivoStockCSV);
    }

    function getUnoStock($pk)
    {
        return Pizza::traerUno(Pizzeria::archivoStockCSV, $pk);
    }

    function getVariosStock($pk)
    {
        return ArchivosCSV::traerVarios(
            Pizzeria::archivoStockCSV,
            Pizza::constructorFromArray,
            $pk
        );
    }

    function altaStock($pizza)
    {
        Pizza::agregarUno(
            Pizzeria::archivoStockCSV,
            $pizza
        );
    }

    function borraStock($pk)
    {
        Pizza::borrarUno(
            Pizzeria::archivoStockCSV,
            $pk
        );
    }

    function Modificar($p)
    {
        $arrPersonas = array();

        $a = fopen("./txt/personas.txt", "r");

        while (!feof($a)) {

            $arr = explode("-", fgets($a));

            if (count($arr) > 1) {
                if ((int)$arr[2] == $p->GetDni()) {
                    $persona = $p;
                } else {
                    $persona = new Persona();
                    $persona->SetFoto($arr[3]);
                    $persona->SetDni($arr[2]);
                    $persona->SetNombre($arr[1]);
                    $persona->SetApellido($arr[0]);
                }
                array_push($arrPersonas, $persona);
            }
        }
        fclose($a);

        $a = fopen("./txt/personas.txt", "w");
        fclose($a);

        foreach ($arrPersonas as $p) {
            $p->Insertar();
        }
    }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* VENTAS */
    function getVentas()
    {
        return ArchivosCSV::traerTodos(Pizzeria::archivoVentasCSV, Venta::constructorFromArray);
    }

    function getFhInicio()
    {
        return $this->fhInicio;
    }

    function getFHActual()
    {
        return date(Pizzeria::formatoFecha);
    }

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* OTROS */
    function mostrarListado($listado)
    {
        if (!$listado) {
            echo "listado vacio<br>";
        } else {
            foreach ($listado as $obj) {
                /* requiere que el objeto tenga su metodo mostrar() */
                $obj->mostrar();
            }
        }
    }
}
