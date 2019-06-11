<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (isset($_GET['sabor']) && isset($_GET['tipo'])) {
    $heladeria = new Heladeria('Heladeria los HDP');

    $pk[] = $_GET['sabor'];
    $pk[] = $_GET['tipo'];

    $helado = $heladeria->getUnoStock($pk);
    if ($helado && $helado->cantidad > 0) {
        mensaje('si, hay');
        $helado->mostrar();
    } else {

        $helados = $heladeria->getVariosStock($_GET['sabor']);
        if ($helados) {
            foreach ($helados as $h) {
                if ($h->cantidad > 0) {
                    mensaje('Hay sabor, pero no tipo');
                    $h->mostrar();
                }
            }
        } else {
            mensaje('No hay helado de ese sabor');
        }
    }
} else {
    mensaje('faltan datos de la PK');
}
