<?php

/**
 * 
 */
class Archivos
{

    const formatoFecha = "YmdHis";

    function __construct()
    {
        # code...
    }

    //////////////////////////* CSV */
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

    public static function guardarListadoCSV($nombreArchivo, $listado, $separador = ",")
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

    //////////////////////////* JSON */
    static function leerJSON($nombreArchivo, $constructor)
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

    static function guardarJSON($nombreArchivo, $array)
    {
        $archivo = fopen($nombreArchivo, "a+");
        $linea = implode($separador, $array);
        fputs($archivo, $linea . PHP_EOL);
        fclose($archivo);
    }

    public static function guardarListadoJSON($nombreArchivo, $listado)
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
    //////////////////////////* OTROS */


    public static function cambiarNombre($destino, $nombreNuevo, $concatFecha = false, $formatoFecha = Archivos::formatoFecha)
    {
        $retorno = pathinfo($destino, PATHINFO_DIRNAME) . "/" . $nombreNuevo;
        if ($concatFecha) {
            $retorno = $retorno . "_" . date($formatoFecha);
        }
        $retorno =  $retorno . "." . pathinfo($destino, PATHINFO_EXTENSION);
        return $retorno;
    }

    public static function copiarABackup($rutaOrigen, $nombreCarpetaBackup = "/backup/", $formatoFecha = Archivos::formatoFecha)
    {
        return copy($rutaOrigen, pathinfo($rutaOrigen, PATHINFO_DIRNAME) .  $nombreCarpetaBackup . pathinfo($rutaOrigen, PATHINFO_FILENAME) .  "_" . date($formatoFecha) . "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION));
    }

    public static function parsearPhpInput()
    {
        parse_str(file_get_contents("php://input"), $retorno);
        return $retorno;
    }
}
