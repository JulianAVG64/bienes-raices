<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="entradasBlog[titulo]" placeholder="Titulo Entrada" value="<?php echo s( $entradasBlog->titulo ); ?>" >

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="entradasBlog[imagen]">

    <?php if($entradasBlog->imagen): ?>
        <img src="/imagenesBlog/<?php echo $entradasBlog->imagen; ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="entradasBlog[descripcion]"><?php echo s( $entradasBlog->descripcion ); ?></textarea>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <label for="vendedor">Vendedor</label>
    <select name="entradasBlog[vendedorId]" id="vendedor">
        <option value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option
                <?php echo $entradasBlog->vendedorId === $vendedor->id ? 'selected' : ''; ?>
                value="<?php echo s($vendedor->id); ?>"> <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> </option>
        <?php } ?>
    </select>
</fieldset>