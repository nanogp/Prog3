<?php

if (isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad'])) {

    if ($_POST['tipo'] == "molde" || $_POST['tipo'] == "piedra") {
        if ($_POST['sabor'] == "muzza" || $_POST['sabor'] == "jamon" || $_POST['sabor'] == "especial") {

            if (Pizzeria::pizzaAlta($_POST['sabor'], $_POST['tipo'], $_POST['precio'], $_POST['cantidad'], isset($_FILES['foto']) ? $_FILES['foto'] : null)) {
                mensaje('ok');
            } else {
                mensaje('fallo');
            }
        } else {
            mensaje('sabor invalido');
        }
    } else {
        mensaje('tipo invalido');
    }
} else {
    mensaje('faltan datos');
}
