<?php
use Model\Vendedor;
?>

<section class="blog">
    <h3>Nuestro Blog</h3>

    <?php foreach($entradasBlog as $entradaBlog): ?>

        <?php 
            // Buscar vendedor para esta entrada
            $id = $entradaBlog->vendedorId;
            $vendedor = Vendedor::find($id);
        ?>

        <article class="entrada-blog">
            <div class="imagen">
                <img loading="lazy" src="/imagenesBlog/<?php echo $entradaBlog->imagen; ?>" alt="imagen entrada">
            </div>

            <div class="texto-entrada">
                <a href="/entrada?id=<?php echo $entradaBlog->id; ?>">
                    <h4><?php echo $entradaBlog->titulo; ?></h4>
                    <p class="informacion-meta">Escrito el: <span><?php echo $entradaBlog->fecha ?></span> por: <span><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></span></p>

                    <p><?php echo $entradaBlog->descripcion; ?></p>
                </a>
            </div>
        </article>
    <?php endforeach; ?>
</section>