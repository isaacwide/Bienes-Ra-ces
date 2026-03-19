<?php



function incluirTemplate(string $nombre,bool $inicio = false) {
    include "includes/templates/$nombre.php";
}