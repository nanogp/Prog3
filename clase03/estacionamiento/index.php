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

    $estacionamiento = new Estacionamiento("Lopecito Appart Car");

    //$estacionamiento->leerCSV();

    $metodo = $_SERVER['REQUEST_METHOD'];
    switch ($metodo) {
        case "GET":
            if (isset($_GET["accion"])) {
                switch ($_GET["accion"]) {
                    case 'mostrarListado':
                        $estacionamiento->leerCSV();
                        $estacionamiento->mostrar();
                        break;
                    case 'alta':
                        if (isset($_GET["patente"])) {
                            $estacionamiento->addVehiculo($_GET["patente"]);
                        } else {
                            echo "no hay patente informada<br>";
                        }
                        break;
                    default:
                        echo "en desarrollo<br>";
                        break;
                }
            }
            break;
        case "POST":
            if (isset($_POST["accion"])) {

                switch ($_POST["accion"]) {
                    case 'alta':
                        if (isset($_POST["patente"])) {
                            $estacionamiento->addVehiculo($_POST["patente"]);
                        } else {
                            echo "no hay patente informada<br>";
                        }
                        break;
                    case 'guardarCsv':
                        $estacionamiento->guardarCSV();
                        break;
                    case 'guardarListadoCsv':
                        $estacionamiento->guardarListadoCSV();
                        break;
                    default:
                        echo "en desarrollo<br>";
                        break;
                }
            }
            break;
        case "DELETE":
            echo "en desarrollo<br>";
            break;
        case "PUT":
            echo "en desarrollo<br>";
            break;
    } //switch

    ?>

</body>

</html>