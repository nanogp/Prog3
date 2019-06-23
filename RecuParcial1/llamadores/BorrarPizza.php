<?php
/* (2 pts.) ​BorrarPizza.php​(por DELETE), debe recibir los datos de Sabor y Tipo,
de encontrarse en el archivo sedeben borrar esos datos y mover la foto a la 
carpeta​ /backUpFotos​  y  sumarle al nombre la fecha de hoy */


if (isset($_POST['sabor']) && isset($_POST['tipo'])) {

    if (Pizzeria::pizzaBaja($_POST['sabor'], $_POST['tipo'])) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
