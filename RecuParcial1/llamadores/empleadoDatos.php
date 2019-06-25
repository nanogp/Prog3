<?php

if (isset($_PUT['email'])  && isset($_PUT['tipo'])) {

    if (Pizzeria::empleadoModificar($_PUT['email'], $_PUT['tipo'])) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
