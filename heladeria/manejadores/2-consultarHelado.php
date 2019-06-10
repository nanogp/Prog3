<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (
    isset($_GET['sabor']) && isset($_GET['tipo'])
) {
    array_push($pk, $_GET['sabor']);
    array_push($pk, $_GET['tipo']);
    $heladeria->getUnoStock($pk)->mostrar();
} else {
    mensaje('faltan datos de la PK');
}
