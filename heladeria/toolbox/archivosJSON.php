<?php

require_once 'archivos.php';

class ArchivosJSON extends Archivos
{
    //constructor privado
    private function __construct()
    { }

    static function traerUno($nombreArchivo, $constructor, $arrayID, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "r");
        $retorno = null; //si no lo encuentra retorna null
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);
                for ($i = 0; $i < count($arrayPK); $i++) {
                    if ($arrayDeDatos[i] === $arrayID[i]) {
                        $hayCoincidencia = true;
                    } else {
                        $hayCoincidencia = false;
                    }
                }

                if ($hayCoincidencia) {
                    /* encontre el dato*/
                    $retorno = call_user_func($constructor, $arrayDeDatos);
                    break; /* dejo de leer archivo */
                }
            }
        }
        fclose($archivo);
        return $retorno;
    }

    static function traerVarios($nombreArchivo, $constructor, $arrayID, $separador = ",")
    {
        /* trae un array de objetos en los que coincide al menos una clave de la PK */
        $archivo = fopen($nombreArchivo, "r");
        $retorno = array(); //si no lo encuentra retorna null
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);
                $hayCoincidencia = false;
                for ($i = 0; $i < count($arrayPK); $i++) {
                    if ($arrayDeDatos[i] === $arrayID[i]) {
                        $hayCoincidencia = true;
                        break; /* rompo el for a la primera clave que coincida */
                    }
                }

                if ($hayCoincidencia) {
                    /* agrego dato al array y sigo leyendo el archivo*/
                    array_push($retorno,  call_user_func($constructor, $arrayDeDatos));
                }
            }
        }
        fclose($archivo);
        return $retorno;
    }

    static function traerTodos($nombreArchivo, $constructor, $separador = ",")
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

    static function guardarUno($nombreArchivo, $array, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "a+");
        $linea = implode($separador, $array);
        fputs($archivo, $linea . PHP_EOL);
        fclose($archivo);
    }

    public static function guardarTodos($nombreArchivo, $listado, $separador = ",")
    {
        /* requiere que el objeto a guardar tenga su metodo toArray() */
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
?>