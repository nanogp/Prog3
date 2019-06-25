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

    public static function moverArchivoBackup($archivoOriginal, $nuevoArchivo, $destino)
    {
        $arrayDeDatos = explode('.', $archivoOriginal); //agarramos el archivo original y lo desarmamos
        $nuevoDestino = "./backUpFotos/" . $nuevoArchivo . date("Y-m-d_h_m_s") . ".$arrayDeDatos[1]"; //hacemos un nuevo destino url con el nuevo nombre de archivo y la extension del original
        echo "NUEVO DESTINO $nuevoDestino";
        copy($destino, $nuevoDestino); //movemos ese archivo al nuevo destino
        $destino = "./archivos/" . $nuevoArchivo . ".$arrayDeDatos[1]";
        return TRUE;
    }

    public static function moverABackup($rutaOrigen, $rutaBackup = null, $concatFecha = true, $formatoFecha = self::formatoFecha)
    {
        return self::copiarABackup($rutaOrigen, $rutaBackup, $concatFecha, $formatoFecha, true);
    }

    public static function copiarABackup($rutaOrigen, $rutaBackup = null, $concatFecha = true, $formatoFecha = self::formatoFecha, $mover = false)
    {
        //base de ruta
        if ($rutaBackup) {
            $rutaDestino = $rutaBackup;
        } else {
            $rutaDestino = pathinfo($rutaOrigen, PATHINFO_DIRNAME) . "/backup/";
        }

        //nombre de archivo
        $rutaDestino .= pathinfo($rutaOrigen, PATHINFO_FILENAME);

        //fecha
        if ($concatFecha) {
            $rutaDestino .=  "_" . date($formatoFecha);
        }

        //extension
        $rutaDestino .= "." . pathinfo($rutaOrigen, PATHINFO_EXTENSION);

        /* $rutaOrigen = str_replace("/", DIRECTORY_SEPARATOR, $rutaOrigen);
        $rutaDestino = str_replace("/", DIRECTORY_SEPARATOR, $rutaDestino); */

        mensaje("RUTA ORIGEN $rutaOrigen <br>");
        mensaje("RUTA DESTINO $rutaDestino <br>");

        $retorno = copy($rutaOrigen, $rutaDestino);
        if ($mover) {
            unlink($destino);
        }
        return $retorno;
    }

    public static function parsearPhpInput()
    {
        parse_str(file_get_contents("php://input"), $retorno);
        return $retorno;
    }
}
