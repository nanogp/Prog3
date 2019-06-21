<?php

if (isset($_GET['sabor']) && isset($_GET['precio']) && isset($_GET['tipo']) && isset($_GET['cantidad'])) {

    if ($_GET['tipo'] == "molde" || $_GET['tipo'] == "piedra") {
        if ($_GET['sabor'] == "muzza" || $_GET['sabor'] == "jamon" || $_GET['sabor'] == "especial") {

            if (Pizzeria::pizzaAlta($_GET['sabor'], $_GET['tipo'], $_GET['precio'], $_GET['cantidad'])) {
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
