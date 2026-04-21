<?php
session_start();
include '../config/conexion.php';

// Verificamos que venga del formulario Y que el usuario esté logueado
if (isset($_POST['enviar_comentario']) && isset($_SESSION['id_usuario'])) {
    
    $id_video = intval($_POST['id_video']);
    $id_usuario = $_SESSION['id_usuario']; // ID real de la tabla usuarios
    $nombre_oficial = mysqli_real_escape_string($conexion, $_SESSION['nombre']); // Nombre real
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
    $fecha = date('Y-m-d H:i:s');

    // Insertamos vinculando el ID del usuario para el Historial Clínico futuro
    $query = "INSERT INTO comentarios (id_video, id_usuario, nombre_usuario, comentario, fecha, estado) 
              VALUES ($id_video, $id_usuario, '$nombre_oficial', '$comentario', '$fecha', 'pendiente')";

    if (mysqli_query($conexion, $query)) {
        header("Location: ../videos.php?v=$id_video&status=success");
        exit(); 
    } else {
        echo "Error en la base de datos: " . mysqli_error($conexion);
    }
} else {
    // Si intenta entrar sin sesión, lo mandamos al login
    header("Location: ../login.php");
    exit();
}