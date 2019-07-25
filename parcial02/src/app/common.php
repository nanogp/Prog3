<?php

include_once __DIR__ . "/Upload.php";
include_once __DIR__ . "/Imagenes.php";

function MeterAlgoAlBody($request, $response, $args)
{
    $response->getBody()->write("TEXTO DE PRUEBA");

    return $response;
}

//unique false para matchear con cualquier atributo
function compararPk($array, $pk, $unique = true)
{
    foreach ($pk as $key => $value) {
        if ($array[$key] == $value) {
            $hayCoincidencia = true;
        } else {
            $hayCoincidencia = false;
            if ($unique) {
                break; //rompo for con primera key que no coincide
            }
        }
    }
    return $hayCoincidencia;
}

function contiene($listado, $pk)
{
    $hayCoincidencia = false;
    foreach ($listado as $objeto) {
        $hayCoincidencia = compararPk($objeto, $pk);
        if ($hayCoincidencia) {
            break;
        }
    }
    return $hayCoincidencia;
}

function buscar($listado, $pk)
{
    foreach ($listado as $objeto) {
        $hayCoincidencia = compararPk($objeto, $pk);
        if ($hayCoincidencia) {
            $hayCoincidencia = $objeto;
            break;
        }
    }
    return $hayCoincidencia;
}

function createArray($request, $pk)
{
    foreach ($pk as $key) {
        $retorno[$key] = $request[$key];
    }
    return $retorno;
}

function createProperties($objeto, $request, $array)
{
    foreach ($array as $key) {
        $objeto->{$key} = $request[$key];
    }
    return $objeto;
}

function createProperty($objeto, $name, $value)
{
    $objeto->{$name} = $value;
}

function salto()
{
    echo "<br>";
}
