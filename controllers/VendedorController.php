<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear( Router $router) {
        
        // Arreglo (inicialmente vacío) con mensajes de errores
        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
    
            // Validar que no hayan campos vacios
            $errores = $vendedor->validar();
    
            // No hay errores
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);

    }

    public static function actualizar( Router $router) {

        // Arreglo (inicialmente vacío) con mensajes de errores
        $errores = Vendedor::getErrores();

        // Obtener y validar ID
        $id = validarORedureccionar('/admin');

        // Obtener el arreglo del vendedor
        $vendedor = Vendedor::find($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los valores
            $args = $_POST['vendedor'];
    
            // Sincronizar objeto en memoria con lo que el usuario escribió
            $vendedor->sincronizar($args);
    
            // Validación
            $errores = $vendedor->validar();
    
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);

    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
    
                $tipo = $_POST['tipo'];
                
                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}