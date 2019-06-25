<?php

if (isset($_GET["tipo"])) {
    Pizzeria::ListarEmpleados($_GET["tipo"]);
} else {
    mensaje('falta informar [tipo] de listado');
}
