<?php

if (isset($_POST['alias']) && isset($_POST['email']) && isset($_POST['tipo']) && isset($_POST['edad'])) {


    if (Pizzeria::empleadoAlta($_POST['email'], $_POST['alias'], $_POST['tipo'],  $_POST['edad'], isset($_FILES['foto']) ? $_FILES['foto'] : null)) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
