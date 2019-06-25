<?php

if (isset($_GET["tipo"])) {
    Pizzeria::ListarImagenes($_GET["tipo"]);
} else {
    mensaje('falta informar tipo');
}
