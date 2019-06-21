<?php

if (isset($_POST['sabor']) && isset($_POST['tipo'])) {
    Pizzeria::pizzaConsultar($_POST['sabor'], $_POST['tipo']);
} else {
    mensaje('faltan datos');
}
