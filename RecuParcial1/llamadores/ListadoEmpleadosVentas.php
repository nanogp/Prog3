<?php

if (isset($_GET["email"])) {
    Pizzeria::ListarEmpleadosVentas($_GET["email"]);
} else {
    mensaje('falta informar email');
}
