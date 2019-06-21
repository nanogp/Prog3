<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parcial Pizzeria</title>
</head>

<body>

    <?php
    require_once 'toolbox/mensajes.php';
    require_once 'clases/pizzeria.php';

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch (key($_GET)) {
                case 'pruebas':
                    require_once 'clases/Pizzeria.php';

                    $p = new Pizza(2, 'muzza', 'molde', 'precio', 'cantidad');
                    //Pizza::mostrarLista(Pizza::traerLista(Pizzeria::rutaArchivoPizzas));
                    //Pizzeria::pizzaConsultar('muzza', 'piedras');

                    Pizza::mostrarLista(ArchivosJSON::traerVarios(
                        Pizzeria::rutaArchivoPizzas,
                        Pizza::nombreConstructorJSON,
                        array('tipo' => 'molde')
                    ));

                    break;
                default:
                    require_once 'llamadores/PizzaCarga.php';
                    break;
            }
            break;
        case 'POST':
            switch (key($_POST)) {
                case 'pizzaconsultar':
                    require_once 'llamadores/PizzaConsultar.php';
                    break;
                case 'altaventa':
                    require_once 'llamadores/AltaVenta.php';
                    break;
                default:
                    mensaje('puto el que lee');
                    break;
            }
    }
    ?>

</body>

</html>