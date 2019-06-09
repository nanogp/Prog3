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
?>