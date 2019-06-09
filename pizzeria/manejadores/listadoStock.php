<?php
require_once 'clases/pizza.php';
require_once 'clases/pizzeria.php';

$pizzeria = new Pizzeria('Los HDP');

$metodo = $_SERVER['REQUEST_METHOD'];
if (isset($_GET['accion'])) {
    $pk = array();
    switch ($_GET['accion']) {
        case 'getTodos':
            $pizzeria->mostrarListado($pizzeria->getStock());
            break;
        case 'getUno':
            if (
                isset($_GET['sabor']) && isset($_GET['tipo'])
            ) {
                array_push($pk, $_GET['sabor']);
                array_push($pk, $_GET['tipo']);
                $pizzeria->getUnoStock($pk)->mostrar();
            } else {
                mensaje('faltan datos de la PK');
            }
            break;
        case 'getVarios':
            if (isset($_GET['sabor']) || isset($_GET['tipo'])) {
                if (isset($_GET['sabor'])) {
                    array_push($pk, $_GET['sabor']);
                }

                if (isset($_GET['tipo'])) {
                    array_push($pk, $_GET['tipo']);
                }

                $pizzeria->mostrarListado($pizzeria->getVariosStock($pk));
            } else {
                mensaje('no hay ningun dato de la PK');
            }
            break;
        default:
            mensaje(var_dump($_GET));
            break;
    }
} else {
    mensaje('accion no seteada');
}
