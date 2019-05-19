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

    static function leerCSV($nombreArchivo, $constructor)
    {
        $archivo = fopen($nombreArchivo, "r");
        $retorno = array();

        while (!feof($archivo)) {

            $linea = fgets($archivo);
            $arrayDeDatos = explode(",", $linea);
            $dato = call_user_func($constructor, $arrayDeDatos);
            array_push($retorno, $dato);
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
            if ($objeto != "") {
                for ($i = 0,  $array = $objeto->toArray(); $i < count($array); $i++) {
                    if ($i == 0) {
                        $dato = $array[$i];
                    } else {
                        $dato = $dato . $separador . $array[$i];
                    }
                }
            }
            fputs($archivo, $dato);
        }
        fputs($archivo, PHP_EOL);
        fclose($archivo);
    }
    /*
    public static function GuardarListadoCSV($nombreArchivo, $listado, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "w");

        foreach ($listado as $objeto) {
            $dato = "";
            if ($objeto != "") {
                foreach ($objeto->toArray() as $campo) {
                    $dato = $dato . $campo . $separador;
                }
                $dato = rtrim($dato, $separador);
            }
            fputs($archivo, $dato);
        }
        fputs($archivo, PHP_EOL);
        fclose($archivo);
    }
    */
}
