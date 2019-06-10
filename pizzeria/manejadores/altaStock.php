<?php

if (
    isset($_POST['sabor']) &&
    isset($_POST['tipo']) &&
    isset($_POST['importe'])
) {
    if (isset($_POST['stock'])) {
        $cantidad = $_POST['stock'];
    } else {
        $cantidad  = 0;
    }

    $pizza = new  Pizza($_POST['sabor'], $_POST['tipo'], $_POST['importe'], $cantidad);

    $existente = Pizza::traerUno(Pizzeria::archivoStockCSV, $pizza->pkToArray());

    if ($existente === null) {
        Pizza::agregarUno(Pizzeria::archivoStockCSV, $pizza);
        mensaje('se hizo el alta ingresada');
    } else {
        mensaje('ya existe el alta ingresada');
        $existente->mostrar();
    }
} else {
    mensaje('faltan datos');
}
