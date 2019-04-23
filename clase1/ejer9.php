<?php

echo "Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la función rand). Mediante una estructura condicional, determinar si el promedio de los números son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el resultado.";

echo "<br><br><br>";

$suma = 0;

for ($i=0; $i < 5; $i++) { 
	$a[$i] = rand(1,9);
	$suma += $a[$i];
	print(($i+1).": ".$a[$i])."<br>";
}

$promedio = $suma / 5;

if($promedio > 6)
{
	echo "promedio ".$promedio." mayor que 6";
}
else if($promedio < 6)
{
	echo "promedio ".$promedio." menor que 6";
}
else
{
	echo "promedio ".$promedio." igual a 6";
}

?>