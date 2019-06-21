<?php

require_once 'archivos.php';

class Imagenes extends Archivos
{
    //constructor privado
    private function __construct()
    { }

    public static function marcaDeAgua($imgOrigen, $imgMarca)
    {
        $estampa = imagecreatefrompng($imgMarca);
        $im = imagecreatefromjpeg($imgOrigen);

        // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
        $margen_dcho = 10;
        $margen_inf = 10;
        $sx = imagesx($estampa);
        $sy = imagesy($estampa);

        // Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el
        // ancho de la foto para calcular la posición de la estampa. 
        imagecopy($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa));

        // Imprimir y liberar memoria
        //header('Content-type: image/png');
        imagepng($im);
    }

    //INDICO CUAL SERA EL DESTINO DEL ARCHIVO SUBIDO
    //$destino = "archivos/" . trim($_FILES["archivo"]["name"], "_");

    public static function upload($destino, $file)
    {
        $retorno = TRUE;

        //PATHINFO RETORNA UN ARRAY CON INFORMACION DEL PATH
        //RETORNA : NOMBRE DEL DIRECTORIO; NOMBRE DEL ARCHIVO; EXTENSION DEL ARCHIVO

        //PATHINFO_DIRNAME - retorna solo nombre del directorio
        //PATHINFO_BASENAME - retorna solo el nombre del archivo (con la extension)
        //PATHINFO_EXTENSION - retorna solo extension
        //PATHINFO_FILENAME - retorna solo el nombre del archivo (sin la extension)

        //echo var_dump( pathinfo($destino));die();

        $tipoArchivo = pathinfo($file, PATHINFO_EXTENSION);

        /*  if (isset($_POST["nombre"])) {
            $destino = self::cambiarNombre($destino, $_POST["nombre"]);
        } */

        //VERIFICO QUE EL ARCHIVO NO EXISTA
        if (file_exists($destino)) {
            //$retorno = FALSE;
            self::copiarABackup($destino);
        }

        //VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
        if ($file["size"] > 500000) {
            echo "El archivo es demasiado grande. Verifique!!!";
            $retorno = FALSE;
        }

        //VERIFICO SI ES UNA IMAGEN O NO
        //var_dump(getimagesize($_FILES["archivo"]["tmp_name"]));die();

        //OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
        //IMAGEN, RETORNA FALSE
        $esImagen = getimagesize($file["tmp_name"]);

        if ($esImagen === FALSE) { //NO ES UNA IMAGEN

            //SOLO PERMITO CIERTAS EXTENSIONES
            if (
                $tipoArchivo != "doc" &&
                $tipoArchivo != "txt" &&
                $tipoArchivo != "rar"
            ) {
                echo "Solo son permitidos archivos con extension DOC, TXT o RAR.";
                $retorno = FALSE;
            }
        } else { // ES UNA IMAGEN

            //SOLO PERMITO CIERTAS EXTENSIONES
            if (
                $tipoArchivo != "jpg" &&
                $tipoArchivo != "jpeg" &&
                $tipoArchivo != "gif" &&
                $tipoArchivo != "png"
            ) {
                echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
                $retorno = FALSE;
            }
        }

        //VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $retorno
        if ($retorno) {
            //MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
            if (move_uploaded_file($file["tmp_name"], $destino)) {

                $imgMarcaDeAgua = "archivos/marcaAgua.png";
                self::marcaDeAgua($destino, $imgMarcaDeAgua);

                //echo "<br/>El archivo " . basename($file["name"]) . " ha sido subido exitosamente.";
                $retorno = true;
            } else {
                //echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo.";
                $retorno = false;
            }
        }
        return $retorno;
    }
}
