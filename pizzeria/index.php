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
    $metodo = $_SERVER['REQUEST_METHOD'];
    switch ($metodo) {
        case 'GET':
            require_once 'listado.php';
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