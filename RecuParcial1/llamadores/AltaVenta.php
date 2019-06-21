<?php

if (isset($_POST['sabor']) && isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['cantidad'])) {
    if (isset($_FILES['foto'])) {
        $foto = $_FILES['foto'];
    } else {
        $foto = null;
    }

    if (Pizzeria::ventaAlta($_POST['email'], $_POST['sabor'], $_POST['tipo'],  $_POST['cantidad'], $foto)) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
