<main class="contenedor seccion contenido-centrado">

    <h1><?php echo $entrada->titulo; ?></h1>

    <img loading="lazy" src="/imagenesBlog/<?php echo $entrada->imagen ?>" alt="imagen de la entrada">

    <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha ?></span> por: <span><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></span></p>

    <div class="resumen-propiedad">

        <p><?php echo $entrada->descripcion; ?></p>
    </div>

    <a href="/" class="boton boton-verde">Volver</a>
</main>