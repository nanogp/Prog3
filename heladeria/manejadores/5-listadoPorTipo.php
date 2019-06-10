<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (isset($_GET['sabor']) || isset($_GET['tipo'])) {
    if (isset($_GET['sabor'])) {
        array_push($pk, $_GET['sabor']);
    }

    if (isset($_GET['tipo'])) {
        array_push($pk, $_GET['tipo']);
    }

    $pizzeria->mostrarListado($pizzeria->getVariosStock($pk));
} else {
    mensaje('no hay ningun dato de la PK');
}
