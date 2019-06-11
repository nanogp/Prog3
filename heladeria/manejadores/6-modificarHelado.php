<?php
require_once 'clases/heladeria.php';


if (isset($_PUT['sabor']) && isset($_PUT['tipo'])) {

    if (isset($_PUT['precio'])) {
        $precio = $_PUT['precio'];
    } else {
        $precio = 0;
    }

    if (isset($_PUT['cantidad'])) {
        $cantidad = $_PUT['cantidad'];
    } else {
        $cantidad = 0;
    }

    Heladeria::modificacionHelado($_PUT['sabor'], $_PUT['tipo'], $precio, $cantidad);
} else {
    mensaje('faltan datos para identificar el registro a modificar');
}
