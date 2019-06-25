<?php

require_once 'clases/Pizza.php';
require_once 'clases/Venta.php';
require_once 'clases/Empleado.php';
require_once 'toolbox/Upload.php';

class Pizzeria
{   //--------------------------------------------------------------------------------//
    /* ATRIBUTOS */
    const rutaArchivoPizzas = "./archivos/Pizza.txt";
    const rutaArchivoVentas = "./archivos/Venta.txt";
    const rutaArchivoEmpleados = "./archivos/empleados.txt";
    const rutaImgVentas = "./ImagenesDeLaVenta/";
    const rutaImgPizzas = "./ImagenesDePizzas/";
    const rutaImgEmpleados = "./ImagenesDeEmpleados/";
    const rutaBackupImg = "./backUpFotos/";
    const rutaImgMarcaDeAgua = "./archivos/imgMarcaDeAgua.png";

    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* CONSTRUCTOR */
    private function __construct()
    { }
    //--------------------------------------------------------------------------------//


    //--------------------------------------------------------------------------------//
    /* METODOS DE CLASE */

    private static function pizzaSubirFoto($sabor, $tipo, $foto)
    {
        $destino =
            self::rutaImgPizzas .
            $tipo .
            $sabor .
            '.' .
            pathinfo($foto['name'], PATHINFO_EXTENSION);

        $destinoBackup = self::rutaBackupImg;

        Upload::upload(
            $foto,
            $destino,
            $destinoBackup,
            array('jpg', 'jpeg'),
            true, //esImagen 
            self::rutaImgMarcaDeAgua
        );
    }

    public static function pizzaAlta($sabor, $tipo, $precio, $cantidad, $foto = null)
    {
        $retorno = false;
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        $pizza = new Pizza(Pizza::getNextId($lista), $sabor, $tipo, $precio, $cantidad);
        if (Pizza::contiene($lista, $pizza->pkToAssociativeArray())) {
            mensaje('pizza ya existe'); //puede agregar stock
        } else {
            $retorno = $pizza->Guardar(self::rutaArchivoPizzas);
        }

        if ($retorno && $foto) {
            self::pizzaSubirFoto($sabor, $tipo, $foto);
        }

        return $retorno;
    }

    public static function pizzaConsultar($sabor, $tipo)
    {
        $retorno = false;
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        if (Pizza::contiene($lista, array('sabor' => $sabor, 'tipo' => $tipo))) {
            mensaje('Si Hay');
            $retorno = true;
        } elseif (Pizza::contiene($lista, array('sabor' => $sabor))) {
            mensaje('Hay sabor, pero no tipo');
        } elseif (Pizza::contiene($lista, array('tipo' => $tipo))) {
            mensaje('Hay tipo, pero no sabor');
        } else {
            mensaje('No hay tipo ni sabor');
        }
        return $retorno;
    }

    public static function ventaAlta($email, $sabor, $tipo, $cantidad, $foto = null)
    {
        $retorno = false;
        $listaPizzas = Pizza::traerLista(self::rutaArchivoPizzas);
        $listaVentas = Venta::traerLista(self::rutaArchivoVentas);

        $venta = new Venta(Venta::getNextId($listaVentas), $sabor, $tipo, $email, $cantidad);

        if (Pizzeria::pizzaConsultar($sabor, $tipo)) {

            $pizza = Pizza::buscar($listaPizzas, array('sabor' => $sabor, 'tipo' => $tipo));
            if ($pizza->getCantidad() >= $cantidad) {

                $pizza->setCantidad($pizza->getCantidad() - $cantidad);
                ArchivosJSON::guardarTodos(self::rutaArchivoPizzas, $listaPizzas);
                $retorno = $venta->Guardar(self::rutaArchivoVentas);

                if ($foto) {
                    $destino =
                        self::rutaImgVentas .
                        $tipo .
                        $sabor .
                        explode('@', $email)[0] .
                        date(Archivos::formatoFecha) .
                        '.' .
                        pathinfo($foto['name'], PATHINFO_EXTENSION);

                    Upload::upload(
                        $foto,
                        $destino,
                        null,
                        array('jpg', 'jpeg'),
                        true, //esImagen 
                        self::rutaImgMarcaDeAgua
                    );
                }
            } else {
                mensaje('no hay suficiente stock: ' . $pizza->getCantidad());
            }
        }
        return $retorno;
    }

    public static function pizzaModificar($sabor, $tipo, $precio, $cantidad, $foto = null)
    {
        $retorno = false;
        $lista = Pizza::traerLista(self::rutaArchivoPizzas);
        $pizza = new Pizza(Pizza::getNextId($lista), $sabor, $tipo, $precio, $cantidad);

        if (Pizza::contiene($lista, $pizza->pkToAssociativeArray())) {
            $retorno = Pizza::modificarUno(self::rutaArchivoPizzas, $pizza);
            mensaje('stock y precio actualizado');
        } else {
            $retorno = $pizza->Guardar(self::rutaArchivoPizzas);
        }

        if ($retorno && $foto) {
            mensaje('foto actualizada');
            self::pizzaSubirFoto($sabor, $tipo, $foto);
        }

        return $retorno;
    }

    public static function pizzaBaja($sabor, $tipo)
    {
        $pk = array('sabor' => $sabor, 'tipo' => $tipo);
        $retorno = Pizza::borrarUno(self::rutaArchivoPizzas, $pk);
        if ($retorno) {
            //muevo la foto
            $rutaOrigen = self::rutaImgPizzas . $tipo . $sabor . ".jpg";
            $rutaDestino = self::rutaBackupImg;
            Archivos::moverABackup($rutaOrigen, $rutaDestino);
        } else {
            mensaje('no se encontro');
        }
        return $retorno;
    }

    public static function ListarImagenes($tipo)
    {
        if ($tipo == "borradas") {
            foreach (scandir("backUpFotos/") as $file) {
                if ($file != "." && $file != "..") {
                    if (file_exists("backUpFotos/$file")) {
                        $strHtml = "<img src= backUpFotos/" . $file . " alt=" . " border=3 height=120px width=160px></img></br>";
                        echo $strHtml;
                    }
                }
            }
        } elseif ($tipo == "cargadas") {
            foreach (scandir(self::rutaImgPizzas)  as $file) {
                if ($file != "." && $file != "..") {
                    if (file_exists(self::rutaImgPizzas . $file)) {
                        $strHtml = "<img src=" . self::rutaImgPizzas . $file . " alt=" . " border=3 height=120px width=160px></img></br>";
                        echo $strHtml;
                    }
                }
            }
        } else {
            mensaje('el tipo debe estar entre [borradas, cargadas]');
        }
    }

    public static function empleadoAlta($email, $alias, $tipo, $edad, $foto = null)
    {
        $retorno = false;
        $listaEmpleados = Empleado::traerLista(self::rutaArchivoEmpleados);

        $empleado = new Empleado(Empleado::getNextId($listaEmpleados), $alias, $tipo, $email, $edad);

        if (Empleado::contiene($listaEmpleados, array('email' => $email))) {
            mensaje('El empleado ya existe');
        } else {
            $retorno = $empleado->Guardar(self::rutaArchivoEmpleados);
            if ($foto) {
                $destino =
                    self::rutaImgEmpleados .
                    $email . //explode('@', )[0] .
                    '.' .
                    pathinfo($foto['name'], PATHINFO_EXTENSION);

                Upload::upload(
                    $foto,
                    $destino,
                    null,
                    array('jpg', 'jpeg'),
                    true, //esImagen 
                    null //self::rutaImgMarcaDeAgua
                );
            }
        }
        return $retorno;
    }

    public static function ListarEmpleados($tipo)
    {
        $listaEmpleados = Empleado::traerLista(self::rutaArchivoEmpleados);

        switch ($tipo) {
            case 'conimagenes':
                foreach ($listaEmpleados as $empleado) {
                    echo $empleado->toString();
                    $strHtml = "<img src=" . self::rutaImgEmpleados . $empleado->getEmail() . ".jpg" . " alt=" . " border=3 height=120px width=160px></img></br>";
                    echo $strHtml;
                }
                break;
            case 'sinimagenes':
                foreach ($listaEmpleados as $empleado) {
                    $empleado->mostrar();
                }
                break;
            case 'solonombres':
                foreach ($listaEmpleados as $empleado) {
                    mensaje($empleado->getAlias());
                }
                break;
            default:
                mensaje('el tipo de listado debe estar entre [conimagenes, sinimagenes, solonombres]');
                break;
        }
    }

    public static function empleadoModificar($email, $tipo)
    {
        $retorno = Empleado::modificarUno(self::rutaArchivoEmpleados, new Empleado(null, null, $tipo, $email, null));

        if ($retorno) {
            mensaje('empleado actualizado');
        } else {
            mensaje('no se encontro el empleado');
        }
        return $retorno;
    }


    public static function empleadoBaja($filtro, $case)
    {
        $retorno = false;
        switch ($case) {
            case 'email':
                $pk = array('email' => $filtro);
                break;
            case 'tipo':
                $pk = array('tipo' => $filtro);
                break;
        }

        $listaEmpleados = Empleado::traerLista(self::rutaArchivoEmpleados);

        foreach ($listaEmpleados as $key => $empleado) {
            if (ArchivosJSON::compararPk($empleado->toAssociativeArray(), $pk)) {
                unset($listaEmpleados[$key]);
                $rutaOrigen = self::rutaImgEmpleados . $empleado->getEmail() . ".jpg";
                $rutaDestino = self::rutaBackupImg;
                $retorno = Imagenes::moverABackup($rutaOrigen, $rutaDestino);
            }
        }

        if ($retorno) {
            ArchivosJSON::guardarTodos(self::rutaArchivoEmpleados, $listaEmpleados);
        } else {
            mensaje('no se encontro');
        }
        return $retorno;
    }

    //--------------------------------------------------------------------------------//
}
