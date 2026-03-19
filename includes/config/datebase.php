<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost','root','','bienesraices_crud');

    if(!$db){
        echo"No se conecto tiste pim pim";
        exit;
    }

    return $db;
}
