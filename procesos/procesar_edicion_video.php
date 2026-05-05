<?php
require_once __DIR__ . '/../config/conexion.php';

if (isset($_POST['actualizar_video'])) {
    $id = intval($_POST['id_video']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $url = mysqli_real_escape_string($conexion, $_POST['url']);
    $duracion = intval($_POST['duracion']);

    // Usamos UPDATE para modificar el registro existente
    $sql = "UPDATE videos SET 
            titulo_video = '$titulo', 
            url_youtube = '$url', 
            duracion_minutos = $duracion 
            WHERE id_video = $id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../admin.php?sec=videos&status=updated");
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>