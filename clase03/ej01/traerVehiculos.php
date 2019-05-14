<?php

require_once "./vehiculo.php";

$vehiculos = vehiculo::leer();

foreach ($vehiculos as $v) {
    $v->mostrar();
}
