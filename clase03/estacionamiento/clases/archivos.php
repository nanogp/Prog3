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
        fputs($archivo, $linea.PHP_EOL);
        fclose($archivo);
    }

}

?>