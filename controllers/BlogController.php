<?php 

namespace Controllers;
// El controlador manda llamar las vistas
use MVC\Router;
// Modelos
use Model\Blog;
use Model\Vendedor;
// Intervetion Image
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController {

    public static function crear(Router $router) {
        
        // Arreglo (inicialmente vacío) con mensajes de errores
        $errores = Blog::getErrores();
        $vendedores = Vendedor::all();
        $entradasBlog = new Blog;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** Crea una nueva instancia */
            $entradasBlog = new Blog($_POST['entradasBlog']);

            /** SUBIDA DE ARCHIVOS */

            // Generar un nombre único
            $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";

            // Setea la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['entradasBlog']['tmp_name']['imagen']) {
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($_FILES['entradasBlog']['tmp_name']['imagen'])->cover(800,600);
                $entradasBlog->setImagen($nombreImagen);
            }

            // Validar
            $errores = $entradasBlog->validar();

            // Revisar que el arreglo de errores este vacio
            if(empty($errores)) {

                // Crear carpeta
                if (!is_dir(CARPETA_IMAGENES_BLOG)) {
                    mkdir(CARPETA_IMAGENES_BLOG);
                }

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES_BLOG . $nombreImagen);

                // Guarda en la base de datos
                $entradasBlog->guardar();

            }
        }


        $router->render('entradasBlog/crear', [
            'entradasBlog' => $entradasBlog,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);

    }

    public static function actualizar( Router $router ) {
        
        // Arreglo (inicialmente vacío) con mensajes de errores
        $errores = Blog::getErrores();

        // Obtener y validar ID
        $id = validarORedureccionar('/admin');

        $entradasBlog = Blog::find($id);

        $vendedores = Vendedor::all();

        // Ejecutar el codigo despues de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['entradasBlog'];

            // Sincronizar
            $entradasBlog->sincronizar($args);

            // Validar
            $errores = $entradasBlog->validar();

            // Subida de archivos

            // Generar un nombre único
            $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";

            if($_FILES['entradasBlog']['tmp_name']['imagen']) {
                $manager = new ImageManager(Driver::class);
                $image = $manager->read($_FILES['entradasBlog']['tmp_name']['imagen'])->cover(800,600);
                $entradasBlog->setImagen($nombreImagen);
            }

            // Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                if($_FILES['entradasBlog']['tmp_name']['imagen']) {
                // Almacenar imagen
                $image->save(CARPETA_IMAGENES_BLOG . $nombreImagen);
                }

                // Isertar en la base de datos
                $entradasBlog->guardar();
            }
        }

        $router->render('entradasBlog/actualizar', [
            'entradasBlog' => $entradasBlog,
            'vendedores' => $vendedores,
            'errores' => $errores
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
                    $entradasBlog = Blog::find($id);
                    $entradasBlog->eliminar();
                }
            }
        }
    }
}