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

    public static function cambiarNombre($destino, $nombreNuevo, $concatFecha = false, $formatoFecha = self::formatoFecha)
    {
        $retorno = pathinfo($destino, PATHINFO_DIRNAME) . "/" . $nombreNuevo;
        if ($concatFecha) {
            $retorno = $retorno . "_" . date($formatoFecha);
        }
        $retorno =  $retorno . "." . pathinfo($destino, PATHINFO_EXTENSION);
        return $retorno;
    }

    public static function copiarABackup($rutaOrigen, $nombreCarpetaBackup = "/backup/", $formatoFecha = self::formatoFecha)
    {
        return copy($rutaOrigen, pathinfo($rutaOrigen, PATHINFO_DIRNAME) .  $nombreCarpetaBackup . pathinfo($rutaOrigen, PATHINFO_FILENAME) .  "_" . date($formatoFecha) . "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION));
    }

    public static function parsearPhpInput()
    {
        parse_str(file_get_contents("php://input"), $retorno);
        return $retorno;
    }

    static function compararPk($arrayDeDatos, $pk)
    {
        for ($i = 0; $i < count($pk); $i++) {
            if ($arrayDeDatos[$i] === $pk[$i]) {
                $hayCoincidencia = true;
            } else {
                $hayCoincidencia = false;
                break;
            }
        }
        return $hayCoincidencia;
    }

    static function contieneListado($listado, $pk)
    {
        $hayCoincidencia = null;
        foreach ($listado as $objeto) {
            $hayCoincidencia = self::compararPk($objeto->toArray(), $pk);
            if ($hayCoincidencia) {
                break;
            }
        }
        return $hayCoincidencia;
    }

    static function borrarDeListado($array, $pk)
    {
        return array_filter(
            $array,
            function ($objeto) use ($pk) {
                return !self::compararPk($objeto->toArray(), $pk);
            }
        );
    }
}
