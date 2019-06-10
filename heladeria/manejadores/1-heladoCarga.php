<?php
require_once 'clases/helado.php';
require_once 'clases/heladeria.php';

if (isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['precio'])) {
    if (in_array($_POST['tipo'], Helado::getTiposValidos())) {

        if (isset($_POST['cantidad'])) {
            $cantidad = $_POST['cantidad'];
        } else {
            $cantidad  = 0;
        }

        $helado = new Helado($_POST['sabor'], $_POST['tipo'], $_POST['precio'], $cantidad);

        $existente = Helado::traerUno(Heladeria::archivoStockCSV, $helado->pkToArray());

        if ($existente === null) {
            Helado::agregarUno(Heladeria::archivoStockCSV, $helado);
            mensaje('se hizo el alta ingresada');
        } else {
            mensaje('ya existe el alta ingresada');
            $existente->mostrar();
        }
    } else {
        mensaje('tipo de helado invalido');
    }
} else {
    mensaje('faltan datos');
}
