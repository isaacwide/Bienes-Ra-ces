<?php
    //importamos la conexxcioin
    require __DIR__.'/../includes/config/datebase.php';
    $db = conectarDB();
    $mensaje = $_GET["mensaje"] ?? null;



    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {

            // Eliminar el archivo
            $query = "SELECT imagen FROM propiedades WHERE id = {$id}";

            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            
            unlink('../imagenes/' . $propiedad['imagen']);
    
            // Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('location: /admin?mensaje=3');
            }
        }

        
    }
    require __DIR__ . '/../includes/funciones.php';
    incluirTemplate('header');
    

    

    // Escribir el Query
    $query = "SELECT * FROM propiedades";

    // Consultar la BD 
    $resultadoConsulta = mysqli_query($db, $query);

?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes</h1>

        <?php  if($mensaje == 1):?>
            <p class="alerta exito">Registro exitoso</p>
        <?php elseif( $mensaje  == 2 ): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php elseif( $mensaje  == 3 ): ?>
            <p class="alerta error">Anuncio Eliminacion Exitosa</p>
        <?php endif ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    </main>


    <div class="tabla-contenedor">

    <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los Resultados -->
                <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo $propiedad['id']; ?></td>
                    <td><?php echo $propiedad['titulo']; ?></td>
                    <td>

                        <img src="/imagenes/<?php echo $propiedad['imagen'] ?>" class="imagen-tabla">
                    </td>
                    <td>$ <?php echo $propiedad['precio']; ?></td>
                    <td>
                        <form method="POST" class="w-100">

                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>

    </table>
    
    </div>

    

<?php
    mysqli_close($db);
    incluirTemplate('footer');
?>