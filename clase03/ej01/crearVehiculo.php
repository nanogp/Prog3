<?php

require_once "./vehiculo.php";

$vehiculo = new vehiculo("pte555", "hace rato", "4567987");

$vehiculo->guardar("vehiculos2.txt");

?>