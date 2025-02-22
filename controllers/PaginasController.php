<?php

namespace Controllers;

use Model\Blog;
use MVC\Router;
use Model\Vendedor;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {

    public static function index( Router $router ) {

        // VENDEDORES
        $vendedores = Vendedor::all();

        // ENTRADAS DE BLOG
        $entradasBlog = Blog::get(3);
        
        $propiedades = Propiedad::get(3);

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'entradasBlog' => $entradasBlog,
            'vendedores' => $vendedores
        ]);
    }

    public static function nosotros( Router $router ) {

        $router->render('paginas/nosotros');
    }

    public static function propiedades( Router $router ) {

        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad( Router $router ) {

        $id = validarORedureccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog( Router $router ) {

        // ENTRADAS DE BLOG
        $entradasBlog = Blog::all();

        $router->render('paginas/blog', [
            'entradasBlog' => $entradasBlog
        ]);
    }

    public static function entrada( Router $router ) {

        $id = validarORedureccionar('/');
        $entrada = Blog::find($id);

        // Buscar vendedor para esta entrada
        $id = $entrada->vendedorId;
        $vendedor = Vendedor::find($id);

        $router->render('paginas/entrada', [
            'entrada' => $entrada,
            'vendedor' => $vendedor
        ]);
    }

    public static function contacto( Router $router ) {

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];
            
            // Crear una instacia de PHPMailer
            $mail = new PHPMailer(true);

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'd1c97bfc9d142f';
            $mail->Password = 'f529b6054cbcb4';
            $mail->SMTPSecure = 'tls';
            
            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';
            
            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            

            // Enviar de forma condicional algunos campos de email o teléfono
            if($respuestas['contacto'] === 'telefono') {
                $contenido.= '<p>Eligió ser contactado por teléfonno</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                // Es email, entonces agregamos el campo de email
                $contenido.= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
                
            }
            
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: ' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el email
            if($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' =>$mensaje
        ]);
    }
}