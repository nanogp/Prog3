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
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    require_once './toolbox/mensajes.php';
    require_once './toolbox/archivos.php';
    require_once './toolbox/imagenes.php';

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            switch (key($_GET)) {
                case 'consultarHelado':
                    require_once 'manejadores/2-consultarHelado.php';
                    break;
                case 'listarHelados':
                    require_once 'manejadores/5-listarHelados.php';
                    break;
                default:
                    mensaje('PRUEBAS:');
                    var_dump(key($_GET));
                    break;
            }
            break;
        case "POST":
            switch (key($_POST)) {
                case 'nuevoHelado':
                    if (true) {
                        require_once 'manejadores/7-altaHeladoConFoto.php';
                    } else {
                        require_once 'manejadores/1-heladoCarga.php';
                    }
                    break;
                case 'nuevaVenta':
                    if (isset($_FILES["foto"])) {
                        require_once 'manejadores/4-altaVentaConImagenes.php';
                    } else {
                        require_once 'manejadores/3-altaVenta.php';
                    }
                    break;
            }
            break;
        case "PUT":
            $_PUT = Archivos::parsearPhpInput();
            require_once 'manejadores/6-modificarHelado.php';
            break;
        case "DELETE":
            $_DELETE = Archivos::parsearPhpInput();
            require_once 'manejadores/8-eliminarHelado.php';
            break;
    }
    ?>

</body>

</html>