<?php
echo "Dadas tres variables numéricas de tipo entero \$a, \$b y \$c, realizar una aplicación que muestre el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido. Ejemplo 1: \$a = 6; \$b = 9; \$c = 8; => se muestra 8. Ejemplo 2: \$a = 5; \$b = 1; \$c = 5; => se muestra un mensaje “No hay valor del medio”";
echo "<br><br><br>";

$a = (int)$_GET["a"];
$b = (int)$_GET["b"];
$c = (int)$_GET["c"];

if ($a > $b && $a < $c) {
	print($a);
}
elseif ($b > $a && $b < $c) {
	print($b);
}
elseif ($c > $a && $c < $b) {
	print($c);
}else
{
	print("No hay valor del medio");
}


?>

