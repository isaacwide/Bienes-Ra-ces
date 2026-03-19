<?php 
    // Importar la conexión
    require __DIR__ . '/../config/datebase.php';
    $db = conectarDB();


    // consultar
    // Use braces to avoid deprecated ${var} string syntax
    $query = "SELECT * FROM propiedades LIMIT {$limite}";

    // obtener resultado
    $resultado = mysqli_query($db, $query);


?>

<div class="contenedor-anuncios">
        <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">

            <?php
                // Ruta física en el servidor al directorio compilado de imágenes
                $pathImagen = __DIR__ . '/../../imagenes/' . $propiedad['imagen'];

                // Si la imagen no existe, usar una imagen por defecto para no romper el layout
                if( file_exists($pathImagen) ) {
                    $imgSrc = '/imagenes/' . $propiedad['imagen'];
                } else {
                    $imgSrc = '/build/img/destacada.jpg';
                }
            ?>

            <img loading="lazy" src="<?php echo $imgSrc; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$<?php echo $propiedad['precio']; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad['estacionamientos'] ?? $propiedad['estacionamiento'] ?? 0; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->
        <?php endwhile; ?>
    </div> <!--.contenedor-anuncios-->

<?php 

    // Cerrar la conexión
    mysqli_close($db);
?>