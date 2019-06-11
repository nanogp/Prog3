
<?php

class ManejadorArchivo
{
	public static function moverArchivoBackup($archivoOriginal, $nuevoArchivo, $destino)
	{
		$arrayDeDatos = explode('.', $archivoOriginal); //agarramos el archivo original y lo desarmamos
		$nuevoDestino = "./backup/" . $nuevoArchivo . date("Y-m-d_h_m_s") . ".$arrayDeDatos[1]"; //hacemos un nuevo destino url con el nuevo nombre de archivo y la extension del original

		echo "NUEVO DESTINO $nuevoDestino";
		copy($destino, $nuevoDestino); //movemos ese archivo al nuevo destino

		$destino = "./archivos/" . $nuevoArchivo . ".$arrayDeDatos[1]";

		return TRUE;
	}
}

?>