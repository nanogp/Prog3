<?php

if (
    isset($_DELETE['sabor']) &&
    isset($_DELETE['tipo'])
) {

    $pk  = array($_DELETE['sabor'], $_DELETE['tipo']);
    $listado = Pizza::traerTodos(Pizzeria::archivoStockCSV);

    if (!Archivos::contieneListado($listado, $pk)) {
        mensaje('no se encontro el registro buscado');
    } else {
        Pizza::borrarUno(Pizzeria::archivoStockCSV, $pk);
        mensaje('se borro el registro ingresado');
    }
} else {
    mensaje('faltan datos para identificar el registro a dar de baja');
}
