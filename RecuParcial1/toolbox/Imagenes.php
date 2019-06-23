<?php

require_once 'toolbox/Archivos.php';

class Imagenes extends Archivos
{

    public static function marcaDeAgua($imgOrigen, $imgMarca)
    {
        $estampa = imagecreatefrompng($imgMarca);
        $im = imagecreatefromjpeg($imgOrigen);

        //Achico la estampa
        $estampa = imagescale($estampa, 150, 150);

        // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
        $margen_dcho = 10;
        $margen_inf = 10;
        $sx = imagesx($estampa);
        $sy = imagesy($estampa);

        // Copiar la imagen de la estampa sobre nuestra foto usando los índices de márgen y el
        // ancho de la foto para calcular la posición de la estampa. 
        imagecopy($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, $sx, $sy);

        // Imprimir y liberar memoria
        //header('Content-type: image/png');
        imagepng($im, $imgOrigen);
    }
}
