<?php

namespace App\Models\ORM;

use App\Models\ORM\Imagenes;

include_once __DIR__ . "/Imagenes.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

class Upload extends Archivos
{

	private function __construct()
	{
		//constructor privado
	}

	//INDICO CUAL SERA EL DESTINO DEL ARCHIVO SUBIDO
	//$destino = "archivos/" . trim($_FILES["archivo"]["name"], "_");

	public static function upload($file, $destino, $destinoBackup = null, array $extensiones = null, $esImagen = false, $imgMarcaDeAgua)
	{
		$retorno = true;

		//echo var_dump( pathinfo($destino));die();

		if ($extensiones) {
			if (!self::validarExtensiones($file, $extensiones)) {
				$retorno = false;

				$mensaje = 'solo se permiten archivos: [';
				foreach ($extensiones as $e) {
					$mensaje .= strtoupper($e) . ',';
				}
				$mensaje = rtrim($mensaje, ',');
				$mensaje .= ']';
				salto();
				var_dump($mensaje);
				salto();
			}
		}

		if ($esImagen) {
			//obtiene el tamaño de una imagen, si el archivo no es una imagen, retorna false
			if (!getimagesize($file["tmp_name"])) {
				$retorno = false;

				salto();
				var_dump('se esperaba un archivo de imagen');
				salto();
			}
		}

		//verifico el tamaño maximo que permito subir
		if ($file["size"] > 5000000) {
			$retorno = false;

			salto();
			var_dump("El archivo es demasiado grande. Verifique!!!");
			salto();
		}

		//verifico si hubo algun error, chequeando $retorno
		if ($retorno) {

			//verifico que el archivo no exista
			if (file_exists($destino)) {
				self::copiarABackup($destino, $destinoBackup,  true, self::formatoFecha);
			}

			//muevo el archivo del temporal al destino final
			if (move_uploaded_file($file["tmp_name"], $destino)) {
				if ($imgMarcaDeAgua) {
					Imagenes::marcaDeAgua($destino, $imgMarcaDeAgua);
				}

				salto();
				var_dump("El archivo " . basename($file["name"]) . " ha sido subido exitosamente.");
				salto();
			} else {
				salto();
				var_dump("Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.");
				salto();
				$retorno = false;
			}
		}
		return $retorno;
	}
}
