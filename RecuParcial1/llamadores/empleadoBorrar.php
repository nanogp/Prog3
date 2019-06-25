<?php

if (isset($_DELETE['email'])) {
    if (Pizzeria::empleadoBaja($_DELETE['email'], 'email')) {
        mensaje('baja por email ok');
    } else {
        mensaje('fallo');
    }
} elseif (isset($_DELETE['tipo'])) {
    if (Pizzeria::empleadoBaja($_DELETE['tipo'], 'tipo')) {
        mensaje('baja por tipo ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
