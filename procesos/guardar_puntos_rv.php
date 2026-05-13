<?php
include '../config/conexion.php';

// El entorno de RV enviará estos datos por método POST
if(isset($_POST['id_usuario']) && isset($_POST['puntos_ganados'])) {
    
    $id_usuario = mysqli_real_escape_string($conexion, $_POST['id_usuario']);
    $puntos = mysqli_real_escape_string($conexion, $_POST['puntos_ganados']);
    $ejercicio = mysqli_real_escape_string($conexion, $_POST['nombre_ejercicio']);

    // Insertamos en la tabla indicando que el origen es 'RV'
    $sql = "INSERT INTO avance_usuarios (id_usuario, ejercicio_nombre, puntos, tipo_entorno) 
            VALUES ('$id_usuario', '$ejercicio', '$puntos', 'RV')";
    
    if(mysqli_query($conexion, $sql)) {
        echo "Éxito: Puntos de RV sincronizados";
    }
}
?>