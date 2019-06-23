<?php

if (isset($_POST['sabor']) && isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['cantidad'])) {


    if (Pizzeria::ventaAlta($_POST['email'], $_POST['sabor'], $_POST['tipo'],  $_POST['cantidad'], isset($_FILES['foto']) ? $_FILES['foto'] : null)) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
