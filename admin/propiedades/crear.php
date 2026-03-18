<?php

    // base de datps caon

    require __DIR__ . '/../../includes/config/datebase.php';
    $db = conectarDB();

    $errores =[];

    $consulta = "SELECT * FROM vendedores";

    $res = mysqli_query($db,$consulta);


    $titulo          = '';
    $precio          = '';
    $descripcion     = '';
    $habitaciones    = '';
    $wc              = '';
    $estacionamientos = '';
    $vendedorId        = '';


    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        
        $titulo           = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio           = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion      = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones     = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc               = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamientos = mysqli_real_escape_string($db, $_POST['estacionamientos']);
        $vendedorId       = mysqli_real_escape_string($db, $_POST['vendedor']);


        $imagen = $_FILES['imagen'];


        if(!$titulo){
            $errores[] = "El título es obligatorio";
        }
        if(!$precio){
            $errores[] = "El precio es obligatorio";
        }
        if(!$descripcion or strlen($descripcion)<30){
            $errores[] = "La descripción es obligatoria o es muy corta ";
        }
        if(!$habitaciones){
            $errores[] = "Las habitaciones son obligatorias";
        }
        if(!$wc){
            $errores[] = "Los baños son obligatorios";
        }
        if(!$estacionamientos){
            $errores[] = "Los estacionamientos son obligatorios";
        }
        if(!$vendedorId){
            $errores[] = "El vendedor es obligatorio";
        }
        if(!$imagen['name'] or $imagen['error']){
            $errores[] = "La imagen es obligatoria ";
        }

        if($imagen['size'] > 100 * 1024){
            $errores[] = "La imagen es muy pesada, máximo 100kb";
        }


        if(empty($errores)){
            $query = "INSERT INTO propiedades (titulo,precio,descripcion,habitaciones,wc,estacionamientos,vendedores_id,creado) VALUES('$titulo','$precio','$descripcion','$habitaciones','$wc','$estacionamientos','$vendedorId',NOW())";
            $resultado = mysqli_query($db,$query);
            if($resultado){
                header('Location:/admin');
            }
        }


        
    }
    

    require __DIR__ . '/../../includes/funciones.php';
    incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin"  class = "boton boton-verde">Volver</a>
        <?php foreach($errores as $error) : ?>
                <div class="alerta error">
                    <?php echo $error ?>
                </div>
        <?php endforeach?>
        <form class = "formulario" method = "POST" action = "/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend> Info Propiedad</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id = "titulo" name = "titulo" placeholder="Titulo Propiedad" value = "<?php echo $titulo ?>">       
                
                <label for="precio">Precio:</label>
                <input type="number" id = "precio" name = "precio" placeholder="Precio Propiedad" value = "<?php echo $precio ?>">  


                <label for="imagen">Imagen:</label>
                <input type="file" id = "imagen" accept="image/jpeg, image/png" name = "imagen"> 
                
                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name = "descripcion"><?php echo $descripcion ?></textarea>
        
        
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name = "habitaciones" placeholder="EJ:3" min="1" max="9"  value = "<?php echo $habitaciones ?>">

                <label for="wc">Banos:</label>
                <input type="wc" id="wc" name = "wc" placeholder="EJ:3" min="1" max="9" value = "<?php echo $wc ?>">

                <label for="estacionamientos">Estacionamiento:</label>
                <input type="number" id="estacionamientos" name = "estacionamientos" placeholder="EJ:3" min="1" max="9" value = "<?php echo $estacionamientos ?>">

                
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedor">
                    <option value="">Seleccione una opcion</option>
                    <?php while($row = mysqli_fetch_assoc($res)) :?>
                        <option <?php echo $vendedorId == $row['id'] ? 'selected':''  ?>value="<?php echo $row['id'] ?>"><?php echo $row['nombre']." ".$row['apellido']?></option>
                    <?php endwhile?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class = "boton boton-verde">
        </form>
    </main>

<?php
    
    incluirTemplate('footer');
?>