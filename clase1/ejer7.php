<?php
echo "Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del año es. Utilizar una estructura selectiva múltiple.";

echo "<br><br><br>";

print(date("d/m/Y")."<br>");
print(date("d/m/y")."<br>");
print(date("Y-M-D")."<br>");



switch (date("m")) {
	case 1:
	case 2:
	case 3:
		print("es verano");
		break;
	case 4:
	case 5:
	case 6:
		print("es otoño");
		break;
	case 7:
	case 8:
	case 9:
		print("es invierno");
		break;
	case 10:
	case 11:
	case 12:
		print("es primavera");
		break;
}

?>