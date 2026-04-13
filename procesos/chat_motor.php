<?php
include "../config/conexion.php"; 

if (isset($_POST['texto'])) {
    $msg = mysqli_real_escape_string($conexion, $_POST['texto']);
    $msg_minuscula = strtolower($msg);

    // 1. Buscamos en la memoria (Tabla chatbot)
    $sql = "SELECT respuesta FROM chatbot 
            WHERE '$msg_minuscula' LIKE CONCAT('%', pregunta, '%') 
            OR pregunta LIKE '%$msg_minuscula%' 
            LIMIT 1";
            
    $query = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        echo $data['respuesta'];
    } else {
        // 2. APRENDIZAJE: Si no sabe, lo guarda en la bitácora
        $sql_error = "INSERT INTO dudas_pendientes (pregunta_usuario) VALUES ('$msg')";
        mysqli_query($conexion, $sql_error);

        echo "Aún no tengo esa información, pero ya la anoté para estudiarla. ¿Deseas saber sobre vendajes o ejercicios?";
    }
}
?>