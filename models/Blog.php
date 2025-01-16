<?php

namespace Model;

class Blog extends ActiveRecord {

    protected static $tabla = 'entradasBlog';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'vendedorId', 'imagen', 'descripcion'];

    // Atributos 
    public $id;
    public $titulo;
    public $fecha;
    public $vendedorId;
    public $imagen;
    public $descripcion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
    }

    public function validar() {
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }

        if(!$this->descripcion) {
            self::$errores[] = "Debes añadir una descripción";
        }

        // Validaciones de los archivos
        if(!$this->imagen) {
            self::$errores[] = "La entrada debe tener una imágen";
        }

        return self::$errores;
    }
}