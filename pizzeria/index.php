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

    $metodo = $_SERVER['REQUEST_METHOD'];
    switch ($metodo) {
        case 'GET':
            if (isset($_GET['entidad'])) {
                switch ($_GET['entidad']) {
                    case 'stock':
                        require_once 'listadoStock.php';
                        break;
                    case 'prueba':
                        $patente = $_GET['patente'];
                        //echo preg_match('/^[a-z]{2}[0-9]{3}[a-z]{2}$/i', $patente);
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
            require_once 'alta.php';
            break;
        case 'PUT':
            require_once 'modificacion.php';
            break;
        case 'DELETE':
            require_once 'baja.php';
            break;
    }
    ?>

</body>

</html>