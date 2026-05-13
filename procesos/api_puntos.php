<?php
include '../config/conexion.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_usuario = $_POST['id_usuario'] ?? null;
    $puntos = $_POST['puntos'] ?? 0;
    $ejercicio = $_POST['ejercicio'] ?? 'Sesión RV';

    if ($id_usuario && $puntos > 0) {
        
        $id_usuario = mysqli_real_escape_string($conexion, $id_usuario);
        $puntos = mysqli_real_escape_string($conexion, $puntos);
        $ejercicio = mysqli_real_escape_string($conexion, $ejercicio);

        $sql = "INSERT INTO avance_usuarios (id_usuario, ejercicio_nombre, puntos, tipo_entorno) 
                VALUES ('$id_usuario', '$ejercicio', '$puntos', 'RV')";

        if (mysqli_query($conexion, $sql)) {
            echo json_encode(["status" => "success", "message" => "Puntos guardados correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error en la base de datos"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Datos incompletos (id_usuario o puntos faltantes)"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>