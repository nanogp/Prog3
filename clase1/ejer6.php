<?php
echo "Escribir un programa que use la variable \$operador que pueda almacenar los símbolos matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras \$op1 y \$op2. De acuerdo al símbolo que tenga la variable \$operador, deberá realizarse la operación indicada y mostrarse el resultado por pantalla.";

echo "<br><br><br>";

$operador = $_GET["operador"];
$op1 = (float)$_GET["op1"];
$op2 = (float)$_GET["op2"];

switch ($operador) {
	case "-":
		print($op1." ".$operador." ".$op2." = ".($op1-$op2));
		break;
	
	case "*":
		print($op1." ".$operador." ".$op2." = ".($op1*$op2));
		break;
	
	case "/":
		print($op1." ".$operador." ".$op2." = ".($op1/$op2));
		break;
	
	default:
		print($op1." + ".$op2." = ".(float)($op1+$op2));
		break;
}

?>