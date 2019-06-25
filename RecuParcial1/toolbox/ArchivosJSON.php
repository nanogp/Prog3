<?php

require_once 'Archivos.php';

class ArchivosJSON extends Archivos
{
    //constructor privado
    private function __construct()
    { }

    //unique false para matchear con cualquier atributo
    public static function compararPk($array, $pk, $unique = true)
    {
        foreach ($pk as $key => $value) {
            if ($array[$key] === $value) {
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

    public static function contiene($listado, $pk)
    {
        $hayCoincidencia = false;
        foreach ($listado as $objeto) {
            $hayCoincidencia = self::compararPk($objeto->toAssociativeArray(), $pk);
            if ($hayCoincidencia) {
                break;
            }
        }
        return $hayCoincidencia;
    }

    public static function buscar($listado, $pk)
    {
        foreach ($listado as $objeto) {
            $hayCoincidencia = self::compararPk($objeto->toAssociativeArray(), $pk);
            if ($hayCoincidencia) {
                $hayCoincidencia = $objeto;
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
                return !self::compararPk($objeto->toAssociativeArray(), $pk);
            }
        );
    }

    public static function traerUno($rutaArchivo, $constructor, $pk)
    {
        $archivo = fopen($rutaArchivo, "r");
        if ($archivo) {
            $retorno = null; //si no lo encuentra retorna null
            while (!feof($archivo)) {
                $linea = trim(fgets($archivo));
                if ($linea) {
                    $array = json_decode($linea, true);

                    if (self::compararPk($array, $pk)) {
                        /* encontre el dato*/
                        $retorno = call_user_func($constructor, $array);
                        break; /* dejo de leer archivo */
                    }
                }
            }
            fclose($archivo);
        }
        return $retorno;
    }

    public static function traerVarios($rutaArchivo, $constructor, $pk)
    {
        /* trae un array de objetos en los que coincide al menos una clave de la PK */
        $archivo = fopen($rutaArchivo, "r");
        if ($archivo) {
            $retorno = array(); //si no lo encuentra retorna null
            while (!feof($archivo)) {
                $linea = trim(fgets($archivo));
                if ($linea) {
                    $array = json_decode($linea, true);
                    if (self::compararPk($array, $pk, false)) {
                        /* agrego dato al array y sigo leyendo el archivo*/
                        array_push($retorno,  call_user_func($constructor, $array));
                    }
                }
            }
            fclose($archivo);
        }
        return $retorno;
    }

    public static function traerTodos($rutaArchivo, $constructor)
    {
        $archivo = fopen($rutaArchivo, "r");
        $retorno = array();
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $array = json_decode($linea, true);
                $dato = call_user_func($constructor, $array);
                array_push($retorno, $dato);
            }
        }
        fclose($archivo);
        return $retorno;
    }

    public static function guardarUno($rutaArchivo, $array)
    {
        $archivo = fopen($rutaArchivo, "a+");
        if (!$archivo) {
            $archivo = fopen($rutaArchivo, "w");
        }
        $linea = json_encode($array, JSON_UNESCAPED_UNICODE);
        $retorno = fputs($archivo, $linea . PHP_EOL);
        fclose($archivo);
        return $retorno;
    }

    public static function guardarTodos($rutaArchivo, $listado)
    {
        /* requiere que el objeto a guardar tenga su metodo toAssociativeArray() */
        $archivo = fopen($rutaArchivo, "w");
        foreach ($listado as $objeto) {
            if ($objeto) {
                $linea = json_encode($objeto->toAssociativeArray(), JSON_UNESCAPED_UNICODE);
                $retorno = fputs($archivo, $linea . PHP_EOL);
            }
        }
        fclose($archivo);
        return $retorno;
    }

    public static function borrarUno($rutaArchivo, $constructor, $pk)
    {
        $retorno = false;
        $archivo = fopen($rutaArchivo, "r");
        $arrayDepurado = array();
        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = json_decode($linea, true);
                if (self::compararPk($arrayDeDatos, $pk)) {
                    /* encontre el dato, salteo a la proxima lectura */
                    $retorno = true;
                    continue;
                } else {
                    array_push($arrayDepurado, call_user_func($constructor, $arrayDeDatos));
                }
            }
        }
        fclose($archivo);

        if ($retorno) {
            /* si borro, guardo en el archivo el array depurado */
            self::guardarTodos($rutaArchivo, $arrayDepurado);
        }
        return $retorno;
    }


    public static function modificarUno($rutaArchivo, $constructor, $pk, $reemplazar = null, $acumular = null)
    {
        $retorno = false;
        $archivo = fopen($rutaArchivo, "r");
        $arrayDepurado = array();

        while (!feof($archivo)) {
            $linea = trim(fgets($archivo));
            if ($linea) {
                $arrayDeDatos = json_decode($linea, true);

                if (self::compararPk($arrayDeDatos, $pk)) {
                    /* encontre el dato, lo modifico */
                    if ($reemplazar) {
                        foreach ($reemplazar as $key => $value) {
                            $arrayDeDatos[$key] = $value;
                        }
                    }

                    if ($acumular) {
                        foreach ($acumular as $key => $value) {
                            $arrayDeDatos[$key] += $value;
                        }
                    }

                    $objeto = call_user_func($constructor, $arrayDeDatos);
                    array_push($arrayDepurado, $objeto);
                    $retorno = true;
                } else {
                    array_push($arrayDepurado, call_user_func($constructor, $arrayDeDatos));
                }
            }
        }
        fclose($archivo);

        if ($retorno) {
            //guardo en el archivo actualizado si hubo cambios
            $retorno = self::guardarTodos($rutaArchivo, $arrayDepurado);
        }
        return $retorno;
    }
}
