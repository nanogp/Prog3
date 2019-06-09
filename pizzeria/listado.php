<?php
require_once 'clases/pizza.php';
require_once 'clases/pizzeria.php';

$estacionamiento = new Pizzeria('Los HDP');

$metodo = $_SERVER['REQUEST_METHOD'];
switch ($metodo) {
    case 'GET':
        if (isset($_GET['accion'])) {
            switch ($_GET['accion']) {
                case 'getListado':
                    $estacionamiento->leerCSV();
                    $estacionamiento->mostrarListado();
                    break;
                case 'prueba':
                    $patente = $_GET['patente'];
                    //echo preg_match('/^[a-z]{2}[0-9]{3}[a-z]{2}$/i', $patente);
                    break;
                default:
                    mensajeError('en desarrollo<br>');
                    break;
            }
        } else {
            mensajeError('accion no seteada');
        }
        break;
    case 'POST':
        if (isset($_POST['patente'])) {
            $estacionamiento->addVehiculo($_POST['patente']);
        } else {
            mensajeError('no hay patente informada<br>');
        }
        break;
    case 'PUT':
        $_PUT = Archivos::parsearPhpInput();
        if (isset($_PUT['patente'])) {
            /* foreach ($_PUT as $key => $value) {
                    mensajeError($key . ': ' . $value .  '<br>');
                } */
            if ($estacionamiento->existsVehiculo($_PUT['patente'])) {
                $estacionamiento->putVehiculo($_PUT);
            } else {
                $estacionamiento->pushVehiculo($_PUT['patente']);
            }
        } else {
            mensajeError('no hay patente informada<br>');
        }
        break;
    case 'DELETE':
        mensajeError('en desarrollo<br>');
        break;
} //switch
