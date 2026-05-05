<?php
require_once __DIR__ . '/../config/conexion.php';

if (isset($_POST['nuevo_video'])) {
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $url = mysqli_real_escape_string($conexion, $_POST['url']);
    $duracion = intval($_POST['duracion']);
    $id_cat = intval($_POST['id_categoria']);

    // Cambiamos url_video por url_youtube
$query = "INSERT INTO videos (titulo_video, url_youtube, duracion_minutos, id_categoria) 
          VALUES ('$titulo', '$url', $duracion, $id_cat)";

    if (mysqli_query($conexion, $query)) {
        header("Location: ../admin.php?sec=videos&status=success");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>