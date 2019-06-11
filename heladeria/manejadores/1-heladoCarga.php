<?php
require_once 'clases/heladeria.php';


if (isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['precio'])) {
    if (isset($_POST['cantidad'])) {
        $cantidad = $_POST['cantidad'];
    } else {
        $cantidad = 0;
    }

    Heladeria::altaHelado($_POST['sabor'], $_POST['tipo'], $_POST['precio'], $cantidad);
} else {
    mensaje('faltan datos');
}
