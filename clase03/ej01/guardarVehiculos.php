<?php

require_once "./vehiculo.php";

$vehiculos = vehiculo::leer("./vehiculos.txt");

foreach ($vehiculos as $v) {
    $v->guardar("./nuevo.txt");
}
?>