<?php

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    // Atributos
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {

        if(!$this->nombre) {
            self::$errores[] = "El Nombre es obligatorio";
        }

        if(!$this->apellido) {
            self::$errores[] = "El Apellido es obligatorio";
        }

        if(!$this->telefono) {
            self::$errores[] = "El Teléfono es obligatorio";
        }

        // Usar expresion regular para verificar que sea un numero válido
        if(!preg_match( '/[0-9]{10}/', $this->telefono )) {
            self::$errores[] = "Formato no válido";
        }

        return self::$errores;
    }
}