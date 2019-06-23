<?php

require_once 'toolbox/Imagenes.php';

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

		//PATHINFO RETORNA UN ARRAY CON INFORMACION DEL PATH
		//RETORNA : NOMBRE DEL DIRECTORIO; NOMBRE DEL ARCHIVO; EXTENSION DEL ARCHIVO
		//PATHINFO_DIRNAME - retorna solo nombre del directorio
		//PATHINFO_BASENAME - retorna solo el nombre del archivo (con la extension)
		//PATHINFO_EXTENSION - retorna solo extension
		//PATHINFO_FILENAME - retorna solo el nombre del archivo (sin la extension)

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
				mensaje($mensaje);
			}
		}

		if ($esImagen) {
			//obtiene el tamaño de una imagen, si el archivo no es una imagen, retorna false
			if (!getimagesize($file["tmp_name"])) {
				$retorno = false;

				mensaje('se esperaba un archivo de imagen');
			}
		}

		//verifico el tamaño maximo que permito subir
		if ($file["size"] > 5000000) {
			$retorno = false;

			mensaje("El archivo es demasiado grande. Verifique!!!");
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

				mensaje("<br/>El archivo " . basename($file["name"]) . " ha sido subido exitosamente.");
			} else {
				mensaje("<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.");
				$retorno = false;
			}
		}
		return $retorno;
	}
}
