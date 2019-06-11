<?php
require_once 'clases/heladeria.php';

$pk = array();
if (isset($_GET['sabor']) || isset($_GET['tipo'])) {
    if (isset($_GET['sabor'])) {
        array_push($pk, $_GET['sabor']);
    }

    if (isset($_GET['tipo'])) {
        array_push($pk, $_GET['tipo']);
    }

    Heladeria::mostrarListado(Heladeria::getVariosStock($pk));
} else {
    mensaje('no hay ningun dato de la PK');
}
