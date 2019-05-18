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

        //$auto = new Vehiculo("asd123", "01/01/2019 14:30", "123.56");
        $estacionamiento->leerCSV();

        echo $_SERVER['REQUEST_METHOD']."<br>";
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case "GET":
                echo $_GET["accion"]."<br>";
                switch ($_GET["accion"])
                {
                    case 'mostrarListado':
                        $estacionamiento->mostrar();
                        break;
                    default:
                        echo "en desarrollo<br>";
                        break;
                }
                break;
            case "POST":
                echo "en desarrollo<br>";
                break;
            case "DELETE":
                echo "en desarrollo<br>";
                break;
            case "PUT":
                echo "en desarrollo<br>";
                break;
        } 

    ?>

</body>

</html>