<?php
echo "Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números se sumaron.";
echo "<br><br><br>";

$x = 1;
$i = 1;

while ($x <= 1000) {
	print($x."<br>");
	$x= $x+1;
	$i++;
}

print("se sumaron ".$i." numeros");

?>