<?php
include '../config/conexion.php';

if (isset($_POST['guardar_ejercicio'])) {
    // 1. Recolección de datos y limpieza
    $id = isset($_POST['id_ejercicio']) ? intval($_POST['id_ejercicio']) : 0;
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $series = isset($_POST['series']) ? intval($_POST['series']) : 0;
    $repeticiones = isset($_POST['repeticiones']) ? intval($_POST['repeticiones']) : 0;
    $frecuencia = mysqli_real_escape_string($conexion, $_POST['frecuencia']);
    $nivel_dificultad = mysqli_real_escape_string($conexion, $_POST['nivel_dificultad']);
    $precauciones = mysqli_real_escape_string($conexion, $_POST['precauciones']);

    // 2. Manejo de la Imagen Guía
    $nombre_imagen = "";
    if (isset($_FILES['imagen_guia']) && $_FILES['imagen_guia']['error'] == 0) {
        $ruta_destino = "../assets/img/ejercicios/";
        
        if (!file_exists($ruta_destino)) {
            mkdir($ruta_destino, 0777, true);
        }

        $nombre_imagen = time() . "_" . basename($_FILES['imagen_guia']['name']);
        move_uploaded_file($_FILES['imagen_guia']['tmp_name'], $ruta_destino . $nombre_imagen);
    }

    // 3. Decidir si es INSERT o UPDATE
    if ($id > 0) {
        // --- LÓGICA DE ACTUALIZACIÓN ---
        $extra_img = ($nombre_imagen != "") ? ", imagen_guia='$nombre_imagen'" : "";
        
        $query = "UPDATE ejercicio SET 
                  nombre='$nombre', 
                  descripcion='$descripcion', 
                  series=$series, 
                  repeticiones=$repeticiones, 
                  frecuencia='$frecuencia', 
                  nivel_dificultad='$nivel_dificultad', 
                  precauciones='$precauciones'
                  $extra_img 
                  WHERE id_ejercicio = $id";
    } else {
        // --- LÓGICA DE INSERCIÓN ---
        $img_final = ($nombre_imagen != "") ? $nombre_imagen : "default_ejercicio.jpg";
        
        $query = "INSERT INTO ejercicio 
                  (nombre, descripcion, series, repeticiones, frecuencia, nivel_dificultad, precauciones, imagen_guia) 
                  VALUES 
                  ('$nombre', '$descripcion', $series, $repeticiones, '$frecuencia', '$nivel_dificultad', '$precauciones', '$img_final')";
    }

    // 4. Ejecución y Redirección
    if (mysqli_query($conexion, $query)) {
        header("Location: ../admin.php?sec=ejercicio&status=success");
        exit();
    } else {
        echo "Error en la base de datos: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso denegado.";
}
?>