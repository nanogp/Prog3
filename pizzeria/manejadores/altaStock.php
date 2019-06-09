<?php
require_once 'clases/pizza.php';
require_once 'clases/pizzeria.php';

$pizzeria = new Pizzeria('Los HDP');

$metodo = $_SERVER['REQUEST_METHOD'];
if (
    isset($_POST['sabor']) &&
    isset($_POST['tipo']) &&
    isset($_POST['importe'])
) {
    if (isset($_POST['stock'])) {
        $stock = $_POST['stock'];
    } else {
        $stock  = 0;
    }

    $pizza = new  Pizza(
        $_POST['sabor'],
        $_POST['tipo'],
        $_POST['importe'],
        $stock
    );

    if (!Pizza::traerUno(Pizzeria::archivoStockCSV, $pizza->pkToArray())) {
        Pizza::agregarUno(Pizzeria::archivoStockCSV, $pizza);
        mensaje('se hizo el alta ingresada<br>');
        $pizzeria->mostrarListado($pizzeria->getStock());
    } else {
        mensaje('ya existe el alta ingresada<br>');
        $pizza->mostrar();
    }
} else {
    mensaje('faltan datos');
}
