<?php

/**
 * 
 */
class Archivos
{

    function __construct()
    {
        # code...
    }

    static function leerCSV($nombreArchivo, $constructor, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "r");
        $retorno = array();
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);
                $dato = call_user_func($constructor, $arrayDeDatos);
                array_push($retorno, $dato);
            }
        }
        fclose($archivo);
        return $retorno;
    }

    static function guardarCSV($nombreArchivo, $array, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "a+");
        $linea = implode($separador, $array);
        fputs($archivo, $linea . PHP_EOL);
        fclose($archivo);
    }

    public static function GuardarListadoCSV($nombreArchivo, $listado, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "w");
        foreach ($listado as $objeto) {
            if ($objeto) {
                $linea = implode($separador, $objeto->toArray());
                fputs($archivo, $linea . PHP_EOL);
            }
        }
        fclose($archivo);
    }
}
