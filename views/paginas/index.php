<main class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>

    <?php include 'iconos.php'; ?>
</main>

<section class="seccion contenedor">
    <h2>Casas y Departamentos en Venta</h2>

    <?php
        include 'listado.php';
    ?>

    <div class="alinear-derecha">
        <a class="boton-verde" href="/propiedades">Ver Todas</a>
    </div>

</section>

<section class="imagen-contacto">
    <h2>Encuentra la casa de tus sueños</h2>
    <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>
    <a href="contacto.html" class="boton-amarillo">Contáctanos</a>
</section>

<div class="contenedor seccion seccion-inferior ">

    <?php 
        include 'listadoBlog.php';
    ?>

    <section class="testimoniales">
        <h3>Testimoniales</h3>

        <div class="testimonial">
            <blockquote>
                El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple todas mis expectativas.
            </blockquote>
            <p>- Julian Vargas</p>
        </div>
    </section>
</div>