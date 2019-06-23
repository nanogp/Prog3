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
                case 'pizzacarga':
                    require_once 'llamadores/PizzaCarga.php ';
                    break;
                default:
                    var_dump($_GET);
                    break;
            }
            break;
        case 'POST':
            switch (key($_POST)) {
                case 'pizzacarga':
                    require_once 'llamadores/PizzaCargaFoto.php ';
                    break;
                case 'pizzaconsultar':
                    require_once 'llamadores/PizzaConsultar.php ';
                    break;
                case 'altaventa':
                    require_once 'llamadores/AltaVenta.php ';
                    break;
                case 'pizzacargaplus':
                    require_once 'llamadores/PizzaCargaPlus.php ';
                    break;
                default:
                    var_dump($_POST);
                    break;
            }
            break;
        case 'DELETE':
            require_once 'llamadores/BorrarPizza.php';
            break;
    }
    ?>

</body>

</html>