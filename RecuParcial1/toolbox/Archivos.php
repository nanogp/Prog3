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

    public static function validarExtensiones($file, array $extensiones)
    {
        $retorno = false;
        $tipoArchivo = pathinfo($file['name'], PATHINFO_EXTENSION);

        foreach ($extensiones as $ext) {
            if (strtolower($tipoArchivo) === strtolower($ext)) {
                $retorno = true;
                break;
            }
        }

        return $retorno;
    }

    public static function copiarABackup($rutaOrigen, $rutaBackup = null, $concatFecha = true, $formatoFecha = self::formatoFecha)
    {
        //base de ruta
        $rutaDestino =  pathinfo($rutaOrigen, PATHINFO_DIRNAME);

        if ($rutaBackup) {
            $rutaDestino .= $rutaBackup;
        } else {
            $rutaDestino .= "/backup/";
        }

        //nombre de archivo
        $rutaDestino .= pathinfo($rutaOrigen, PATHINFO_FILENAME);

        //fecha
        if ($concatFecha) {
            $rutaDestino .=  "_" . date($formatoFecha);
        }

        //extension
        $rutaDestino .= "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION);

        var_dump($rutaOrigen);
        mensaje('<br>');
        var_dump($rutaDestino);
        mensaje('<br>');
        return copy($rutaOrigen, $rutaDestino);
    }

    public static function parsearPhpInput()
    {
        parse_str(file_get_contents("php://input"), $retorno);
        return $retorno;
    }
}
