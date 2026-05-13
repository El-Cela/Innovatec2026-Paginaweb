<?php
require_once __DIR__ . '/../config/conexion.php';

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
    
    // --- IMPORTANTE: Capturamos el ID de la categoría que viene del select ---
    $id_categoria = isset($_POST['id_categoria']) ? intval($_POST['id_categoria']) : 1;

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
    
    // IMPORTANTE: id_categoria no lleva comillas simples por ser INT
    $query = "UPDATE series_ejercicio SET 
              nombre = '$nombre', 
              descripcion = '$descripcion', 
              series = $series, 
              repeticiones = $repeticiones, 
              frecuencia = '$frecuencia', 
              nivel_dificultad = '$nivel_dificultad', 
              precauciones = '$precauciones',
              id_categoria = $id_categoria
              $extra_img 
              WHERE id_ejercicio = $id";
} else {
    // --- LÓGICA DE INSERCIÓN ---
    $img_final = ($nombre_imagen != "") ? $nombre_imagen : "default_ejercicio.jpg";
    
    // Asegúrate de que el orden de las columnas coincida EXACTAMENTE con los VALUES
    $query = "INSERT INTO series_ejercicio 
              (nombre, descripcion, series, repeticiones, frecuencia, nivel_dificultad, precauciones, imagen_guia, id_categoria) 
              VALUES 
              ('$nombre', '$descripcion', $series, $repeticiones, '$frecuencia', '$nivel_dificultad', '$precauciones', '$img_final', $id_categoria)";
}

    // 4. Ejecución y Redirección
    if (mysqli_query($conexion, $query)) {
        // Redirigimos de vuelta con éxito
        header("Location: ../admin.php?sec=ejercicio&status=success");
        exit();
    } else {
        // Si hay un error, lo mostramos para depurar (Medicina de precisión)
        echo "Error en la base de datos: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso denegado.";
}
?>