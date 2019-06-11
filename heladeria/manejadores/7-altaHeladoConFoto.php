<?php
require_once 'clases/heladeria.php';

if (isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['precio'])) {
    if (isset($_POST['cantidad'])) {
        $cantidad = $_POST['cantidad'];
    } else {
        $cantidad = 0;
    }
vardump($_POST);
    Heladeria::altaHeladoConFoto($_POST['sabor'], $_POST['tipo'], $_POST['precio'], $cantidad, $_FILES["foto"]);
} else {
    mensaje('faltan datos');
}
