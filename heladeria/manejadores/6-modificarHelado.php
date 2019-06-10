<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (
    isset($_PUT['sabor']) &&
    isset($_PUT['tipo'])
) {
    if (isset($_PUT['importe'])) {
        $importe = $_PUT['importe'];
    } else {
        $importe  = 0;
    }

    if (isset($_PUT['stock'])) {
        $cantidad = $_PUT['stock'];
    } else {
        $cantidad  = 0;
    }

    $helado = new Helado($_PUT['sabor'], $_PUT['tipo'], $importe, $cantidad);

    $listado = Helado::traerTodos(Heladeria::archivoStockCSV);

    if (!Archivos::contieneListado($listado, $helado->pkToArray())) {
        mensaje('no se encontro el registro buscado');
    } else {
        Helado::modificarUno(Heladeria::archivoStockCSV, $helado);
        mensaje('se actualizo el registro ingresado');
    }
} else {
    mensaje('faltan datos para identificar el registro a modificar');
}
