<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

// Usar UTF-8 para evitar errores de caracteres
mysqli_set_charset($conexion, "utf8mb4");

if (isset($_POST['num_tarjeta'])) {
    // NUNCA guardamos el número de tarjeta o CVC por seguridad técnica y legal
    // Solo capturamos datos necesarios para el recibo
    $id_usuario = $_SESSION['id_usuario'];
    $monto = 369.00; // Precio oficial según Plan de Negocios
    
    // Generamos un número de confirmación aleatorio para trazabilidad
    $transaccion_id = bin2hex(random_bytes(8));

    // Solo guardamos el registro del éxito de la transacción
    $sql = "INSERT INTO ventas (id_usuario, monto, metodo_pago, estado) 
            VALUES ('$id_usuario', '$monto', 'Transacción Segura (Token)', 'Completado')";

    if (mysqli_query($conexion, $sql)) {
        // Enviar a éxito
        header("Location: ../index.php?pago=exitoso&id=" . $transaccion_id);
        exit();
    } else {
        // Error de base de datos
        error_log(mysqli_error($conexion)); // Guardar error en log, no mostrar al usuario
        header("Location: ../pago.php?error=sistema");
        exit();
    }
}