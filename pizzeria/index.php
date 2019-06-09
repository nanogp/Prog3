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
    require_once "clases/vehiculo.php";
    require_once "clases/estacionamiento.php";
    require_once "../toolbox/mensajes.php";

    $estacionamiento = new Estacionamiento("Lopecito Appart Car");

    $metodo = $_SERVER['REQUEST_METHOD'];
    switch ($metodo) {
        case "GET":
            if (isset($_GET["accion"])) {
                switch ($_GET["accion"]) {
                    case "getListado":
                        $estacionamiento->leerCSV();
                        $estacionamiento->mostrarListado();
                        break;
                    case "prueba":
                        $patente = $_GET["patente"];
                        echo preg_match("/^[a-z]{2}[0-9]{3}[a-z]{2}$/i", $patente);
                        break;
                    default:
                        mensajeError("en desarrollo<br>");
                        break;
                }
            } else {
                mensajeError("accion no seteada");
            }
            break;
        case "POST":
            if (isset($_POST["patente"])) {
                $estacionamiento->addVehiculo($_POST["patente"]);
            } else {
                mensajeError("no hay patente informada<br>");
            }
            break;
        case "PUT":
            $_PUT = Archivos::parsearPhpInput();
            if (isset($_PUT["patente"])) {
                /* foreach ($_PUT as $key => $value) {
                    mensajeError($key . ": " . $value .  "<br>");
                } */
                if ($estacionamiento->existsVehiculo($_PUT["patente"])) {
                    $estacionamiento->putVehiculo($_PUT);
                } else {
                    $estacionamiento->pushVehiculo($_PUT["patente"]);
                }
            } else {
                mensajeError("no hay patente informada<br>");
            }
            break;
        case "DELETE":
            mensajeError("en desarrollo<br>");
            break;
    } //switch

    ?>

</body>

</html>