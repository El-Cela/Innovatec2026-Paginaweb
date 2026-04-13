<?php
// 1. SALIMOS de la carpeta procesos para encontrar la conexión
include '../config/conexion.php'; 

// 2. El nombre en el isset debe ser el NAME del botón, NO la ruta del archivo
if (isset($_POST['procesar_contenido'])) {
    
    $id = intval($_POST['id_contenido']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $tipo = $_POST['tipo_contenido'];
    $desc = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $slug = mysqli_real_escape_string($conexion, $_POST['slug']);

    // Si el slug está vacío, lo generamos automáticamente
    if(empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo)));
    }

    $nombre_imagen = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // 3. SALIMOS de procesos para llegar a assets/img/
        $ruta_destino = "../assets/img/"; 
        $nombre_imagen = time() . "_" . basename($_FILES['imagen']['name']);
        
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino . $nombre_imagen);
    }

    if ($id > 0) {
        // Lógica de actualización
        if ($nombre_imagen != "") {
            $query = "UPDATE contenidos SET titulo='$titulo', tipo_contenido='$tipo', descripcion='$desc', slug='$slug', imagen_url='$nombre_imagen' WHERE id_contenido = $id";
        } else {
            $query = "UPDATE contenidos SET titulo='$titulo', tipo_contenido='$tipo', descripcion='$desc', slug='$slug' WHERE id_contenido = $id";
        }
    } else {
        // Lógica de inserción
        $img_final = ($nombre_imagen != "") ? $nombre_imagen : "default.jpg";
        $query = "INSERT INTO contenidos (titulo, tipo_contenido, descripcion, slug, imagen_url) VALUES ('$titulo', '$tipo', '$desc', '$slug', '$img_final')";
    }

    if (mysqli_query($conexion, $query)) {
        // 4. SALIMOS de procesos para volver a admin.php
        header("Location: ../admin.php?sec=conceptos&status=success");
        exit();
    } else {
        echo "Error en la base de datos: " . mysqli_error($conexion);
    }
} else {
    // Si alguien intenta entrar directo al archivo sin usar el formulario
    echo "Acceso no autorizado.";
}
?>