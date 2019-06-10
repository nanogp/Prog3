<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="./css/estilos.css"> -->
    <title>Document</title>
</head>

<body>

    <?php
    require_once '../toolbox/mensajes.php';
    require_once '../toolbox/archivos.php';

    $metodo = $_SERVER['REQUEST_METHOD'];
    switch ($metodo) {
        case 'GET':
            if (isset($_GET['entidad'])) {
                switch ($_GET['entidad']) {
                    case 'stock':
                        require_once 'stock.php';
                        break;
                    case 'ventas':
                        require_once 'ventas.php';
                        break;
                    default:
                        mensaje('en desarrollo<br>');
                        break;
                }
            } else {
                mensaje('entidad no seteada');
            }
            break;
        case 'POST':
            if (isset($_POST['entidad'])) {
                switch ($_POST['entidad']) {
                    case 'stock':
                        require_once 'stock.php';
                        break;
                    case 'ventas':
                        require_once 'ventas.php';
                        break;
                    default:
                        mensaje('en desarrollo<br>');
                        break;
                }
            } else {
                mensaje('entidad no seteada');
            }
            break;
        case 'PUT':
            $_PUT = Archivos::parsearPhpInput();
            if (isset($_PUT['entidad'])) {
                switch ($_PUT['entidad']) {
                    case 'stock':
                        require_once 'stock.php';
                        break;
                    case 'ventas':
                        require_once 'ventas.php';
                        break;
                    default:
                        mensaje('en desarrollo<br>');
                        break;
                }
            } else {
                mensaje('entidad no seteada');
            }
            break;
        case 'DELETE':
            $_DELETE = Archivos::parsearPhpInput();
            if (isset($_DELETE['entidad'])) {
                switch ($_DELETE['entidad']) {
                    case 'stock':
                        require_once 'stock.php';
                        break;
                    case 'ventas':
                        require_once 'ventas.php';
                        break;
                    default:
                        mensaje('en desarrollo<br>');
                        break;
                }
            } else {
                mensaje('entidad no seteada');
            }
            break;
    }
    ?>

</body>

</html>