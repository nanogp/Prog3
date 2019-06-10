<?php
require_once 'clases/pizza.php';
require_once 'clases/pizzeria.php';

$pizzeria = new Pizzeria('Los HDP');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once 'manejadores/listadoStock.php';
        break;
    case 'POST':
        require_once 'manejadores/altaStock.php';
        break;
    case 'PUT':
        require_once 'manejadores/modificaStock.php';
        break;
    case 'DELETE':
        require_once 'manejadores/bajaStock.php';
        break;
}

?>