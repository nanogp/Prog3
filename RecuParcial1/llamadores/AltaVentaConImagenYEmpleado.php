<?php
/*
se recibe el email del usuario,email de empleado y elsabor,tipo y cantidad ,
si el ítem existe en ​Pizza.txt, ​y hay stock​​guardar en el archivo de texto ​Venta.txt​ 
todos losdatos  y descontar la cantidad vendida 
*/
if (
    isset($_POST['sabor']) &&
    isset($_POST['emailusuario']) &&
    isset($_POST['emailempleado']) &&
    isset($_POST['tipo']) &&
    isset($_POST['cantidad']) &&
    isset($_FILES['foto'])
) {

    if (Pizzeria::ventaAltaConImagenYEmpleado(
        $_POST['emailusuario'],
        $_POST['emailempleado'],
        $_POST['sabor'],
        $_POST['tipo'],
        $_POST['cantidad'],
        $_FILES['foto']
    )) {
        mensaje('ok');
    } else {
        mensaje('fallo');
    }
} else {
    mensaje('faltan datos');
}
