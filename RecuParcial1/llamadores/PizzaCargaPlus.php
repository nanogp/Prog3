<?php

if (isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad'])) {

    if ($_POST['tipo'] == "molde" || $_POST['tipo'] == "piedra") {
        if (Pizzeria::pizzaModificar($_POST['sabor'], $_POST['tipo'], $_POST['precio'], $_POST['cantidad'], isset($_FILES['foto']) ? $_FILES['foto'] : null)) {
            mensaje('ok');
        } else {
            mensaje('fallo');
        }
    } else {
        mensaje('tipo invalido');
    }
} else {
    mensaje('faltan datos');
}
