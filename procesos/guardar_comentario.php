<?php
include '../config/conexion.php';

if (isset($_POST['enviar_comentario'])) {
    // 1. Recibimos los datos del formulario
    $id_video = intval($_POST['id_video']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre_usuario']); // Capturamos el nombre
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
    $fecha = date('Y-m-d H:i:s');

    // 2. Insertamos en la base de datos
    $query = "INSERT INTO comentarios (id_video, nombre_usuario, comentario, fecha, estado) 
          VALUES ($id_video, '$nombre', '$comentario', '$fecha', 'pendiente')";

    if (mysqli_query($conexion, $query)) {
        // 3. ¡ÉXITO! Regresamos a la página de videos
        header("Location: ../videos.php?v=$id_video&msg=enviado");
        exit(); 
    } else {
        echo "Error al guardar el comentario: " . mysqli_error($conexion);
    }
} else {
    // Si alguien intenta entrar al archivo directo sin enviar el formulario
    header("Location: ../videos.php");
    exit();
}
?>