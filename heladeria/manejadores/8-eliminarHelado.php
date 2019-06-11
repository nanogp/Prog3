<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (
    isset($_DELETE['sabor']) &&
    isset($_DELETE['tipo'])
) {
    Heladeria::borrarHelado($_DELETE['sabor'], $_DELETE['tipo']);
} else {
    mensaje('faltan datos para identificar el registro a dar de baja');
}
