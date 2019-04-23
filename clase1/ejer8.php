<?php
echo "Realizar un programa que en base al valor numérico de la variable \$num, pueda mostrarse por
pantalla, el nombre del número que tenga dentro escrito con palabras, para los números entre
el 20 y el 60.
Por ejemplo, si \$num = 43 debe mostrarse por pantalla “cuarenta y tres”.";

echo "<br><br><br>";

$numero = $_GET["num"];
$unidad = substr($numero, 1);
$decena = substr($numero, 0, 1);



switch ($decena) {
	case 2:
		$nombreDecena = "veinti";
		break;
	
	case 3:
		$nombreDecena = "treinta";
		break;
	
	case 4:
		$nombreDecena = "cuarenta";
		break;
	
	case 5:
		$nombreDecena = "cincuenta";
		break;
	
	case 6:
		$nombreDecena = "sesenta";
		break;
	default:
		print("me la zzzzuda");
		break;
}

switch ($unidad) {
	case 1:
		$nombreUnidad = "uno";
		break;
	
	case 2:
		$nombreUnidad = "dos";
		break;
	
	case 3:
		$nombreUnidad = "tres";
		break;
	
	case 4:
		$nombreUnidad = "cuatro";
		break;
	
	case 5:
		$nombreUnidad = "cinco";
		break;
	
	case 6:
		$nombreUnidad = "seis";
		break;
	
	case 7:
		$nombreUnidad = "siete";
		break;
	
	case 8:
		$nombreUnidad = "ocho";
		break;
	
	case 9:
		$nombreUnidad = "nueve";
		break;
	
	case 0:
		$nombreUnidad = "cero";
		break;
	default:
		$nombreUnidad = "";
		break;
}

if($unidad == 0)
{
	if($decena == 2)
	{
		print("veinte");
	}
	else
	{
		print($nombreDecena);
	}
}
else
{
	if($decena == 2)
	{
		print($nombreDecena.$nombreUnidad);
	}
	else
	{
		print($nombreDecena." y ".$nombreUnidad);
	}
}

?>