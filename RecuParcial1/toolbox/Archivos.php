<?php

/**
 * 
 */
class Archivos
{

    const formatoFecha = "YmdHis";

    //constructor privado
    private function __construct()
    { }

    public static function cambiarNombre($rutaOrigen, $nombreNuevo, $concatFecha = false, $formatoFecha = self::formatoFecha)
    {
        $retorno = pathinfo($rutaOrigen, PATHINFO_DIRNAME) . "/" . $nombreNuevo;
        if ($concatFecha) {
            $retorno = $retorno . "_" . date($formatoFecha);
        }
        $retorno =  $retorno . "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION);
        return $retorno;
    }

    public static function copiarABackup($rutaOrigen, $nombreCarpetaBackup = "/backup/", $concatFecha = true, $formatoFecha = self::formatoFecha)
    {
        return copy($rutaOrigen, pathinfo($rutaOrigen, PATHINFO_DIRNAME) .  $nombreCarpetaBackup . pathinfo($rutaOrigen, PATHINFO_FILENAME) .  "_" . date($formatoFecha) . "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION));
    }

    public static function parsearPhpInput()
    {
        parse_str(file_get_contents("php://input"), $retorno);
        return $retorno;
    }
}
