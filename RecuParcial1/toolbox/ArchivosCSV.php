<?php

require_once 'archivos.php';

class ArchivosCSV extends Archivos
{
    //constructor privado
    private function __construct()
    { }

    //unique false para matchear con cualquier atributo
    public static function compararPk($arrayDeDatos, $pk, $unique = true)
    {
        for ($i = 0; $i < count($pk); $i++) {
            if ($arrayDeDatos[$i] === $pk[$i]) {
                $hayCoincidencia = true;
            } else {
                $hayCoincidencia = false;
                if ($unique) {
                    break; //rompo for con primera key que no coincide
                }
            }
        }
        return $hayCoincidencia;
    }

    public static function contieneListado($listado, $pk)
    {
        foreach ($listado as $objeto) {
            $hayCoincidencia = self::compararPk($objeto->toArray(), $pk);
            if ($hayCoincidencia) {
                break;
            }
        }
        return $hayCoincidencia;
    }

    public static function borrarDeListado($array, $pk)
    {
        return array_filter(
            $array,
            function ($objeto) use ($pk) {
                return !self::compararPk($objeto->toArray(), $pk);
            }
        );
    }

    static function traerUno($nombreArchivo, $constructor, $pk, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "r");
        $retorno = null; //si no lo encuentra retorna null
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);

                if (self::compararPk($arrayDeDatos, $pk)) {
                    /* encontre el dato*/
                    $retorno = call_user_func($constructor, $arrayDeDatos);
                    break; /* dejo de leer archivo */
                }
            }
        }
        fclose($archivo);
        return $retorno;
    }

    static function traerVarios($nombreArchivo, $constructor, $pk, $separador = ",")
    {
        /* trae un array de objetos en los que coincide al menos una clave de la PK */
        $archivo = fopen($nombreArchivo, "r");
        $retorno = array(); //si no lo encuentra retorna null
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);
                $hayCoincidencia = false;
                if (self::compararPk($arrayDeDatos, $pk, false)) {
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

    static function guardarUno($nombreArchivo, $objeto, $separador = ",")
    {
        /* requiere que el objeto a guardar tenga su metodo toArray() */
        $archivo = fopen($nombreArchivo, "a+");
        $linea = implode($separador, $objeto->toArray());
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

    static function borrarUno($nombreArchivo, $constructor, $pk, $separador = ",")
    {
        $archivo = fopen($nombreArchivo, "r");
        $arrayDepurado = array();
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);

                if (self::compararPk($arrayDeDatos, $pk)) {
                    /* encontre el dato, salteo a la proxima lectura */
                    continue;
                } else {
                    array_push($arrayDepurado, call_user_func($constructor, $arrayDeDatos));
                }
            }
        }
        fclose($archivo);

        /* ahora guardo en el archivo el array depurado */
        self::guardarTodos($nombreArchivo, $arrayDepurado);
    }


    static function modificarUno($nombreArchivo, $constructor, $objeto, $separador = ",")
    {
        /* requiere que el objeto tenga sus metodos toArray() y pkToArray() */
        $archivo = fopen($nombreArchivo, "r");
        $arrayDepurado = array();
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = explode($separador, $linea);

                if (self::compararPk($arrayDeDatos, $objeto->pkToArray())) {
                    /* encontre el dato, lo reemplazo con el nuevo */
                    array_push($arrayDepurado, call_user_func($constructor, $objeto->toArray()));
                } else {
                    array_push($arrayDepurado, call_user_func($constructor, $arrayDeDatos));
                }
            }
        }
        fclose($archivo);

        /* ahora guardo en el archivo el array depurado */
        self::guardarTodos($nombreArchivo, $arrayDepurado);
    }
}
