<?php
require_once __DIR__ . '/../config/conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 1. Opcional: Borrar la imagen física de la carpeta para no llenar el servidor
    $res = mysqli_query($conexion, "SELECT imagen_guia FROM ejercicio WHERE id_ejercicio = $id");
    $ejer = mysqli_fetch_assoc($res);
    if ($ejer['imagen_guia'] != 'default_ejercicio.jpg') {
        unlink("../assets/img/ejercicios/" . $ejer['imagen_guia']);
    }

    // 2. Borrar de la base de datos
    $query = "DELETE FROM ejercicio WHERE id_ejercicio = $id";
    
    if (mysqli_query($conexion, $query)) {
        header("Location: ../admin.php?sec=ejercicios&status=deleted");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}
?>