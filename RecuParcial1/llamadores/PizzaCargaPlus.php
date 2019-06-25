<?php

if (isset($_PUT['sabor']) && isset($_PUT['precio']) && isset($_PUT['tipo']) && isset($_PUT['cantidad'])) {

    if ($_PUT['tipo'] == "molde" || $_PUT['tipo'] == "piedra") {
        if (Pizzeria::pizzaModificar($_PUT['sabor'], $_PUT['tipo'], $_PUT['precio'], $_PUT['cantidad'], isset($_FILES['foto']) ? $_FILES['foto'] : null)) {
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
