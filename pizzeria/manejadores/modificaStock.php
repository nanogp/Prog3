<?php

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

    $pizza = new Pizza($_PUT['sabor'], $_PUT['tipo'], $importe, $cantidad);

    $listado = Pizza::traerTodos(Pizzeria::archivoStockCSV);

    if (!Archivos::contieneListado($listado, $pizza->pkToArray())) {
        mensaje('no se encontro el registro buscado');
    } else {
        Pizza::modificarUno(Pizzeria::archivoStockCSV, $pizza);
        mensaje('se actualizo el registro ingresado');
    }
} else {
    mensaje('faltan datos para identificar el registro a modificar');
}
