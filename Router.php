<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas..
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar', '/entradasBlog/crear', '/entradasBlog/actualizar', '/entradasBlog/eliminar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if($fn) {
            // La URL existe y hay una funcion asociada
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = [] ) {

        foreach($datos as $key => $value) {
            // Variable de variable ($$), mantiene el nombre sin perder el valor
            $$key = $value;
        }

        // ob_start inicia almacenamiento en memoria
        ob_start();
        include __DIR__ . "/views/$view.php";

        // Se guarda la variable y se limpia esa memoria
        $contenido = ob_get_clean();

        // La variable guardada se va a pasar automaticamente a la masterpage
        include __DIR__ . "/views/layout.php";
    }
}