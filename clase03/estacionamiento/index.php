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

    $estacionamiento->leerCSV();

    $estacionamiento->guardarListadoCSV();

    //$auto = new Vehiculo("asd123", "01/01/2019 14:30", "123.56");



    /*
    $metodo = $_SERVER['REQUEST_METHOD'];
    echo "REQUEST_METHOD: $metodo<br>";
    switch ($metodo) {
        case "GET":
            if (isset($_GET["accion"])) {
                $accion = $_GET["accion"];
                echo "accion: $accion<br>";

                switch ($accion) {
                    case 'mostrarListado':
                        $estacionamiento->mostrar();
                        break;
                    default:
                        echo "en desarrollo<br>";
                        break;
                }
            }
            break;
        case "POST":
            if (isset($_POST["accion"])) {
                $accion = $_POST["accion"];
                echo "accion: $accion<br>";

                switch ($accion) {
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
    } //switch*/

    ?>

</body>

</html>