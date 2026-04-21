<?php
session_start();
include '../config/conexion.php';

if (isset($_POST['nombre_tarjeta'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $monto = 499.00;
    $fecha = date('Y-m-d H:i:s');
    
    // Aquí podrías crear una tabla llamada 'ventas'
    // INSERT INTO ventas (id_usuario, monto, fecha) VALUES ($id_usuario, $monto, '$fecha')
    
    // Simulamos éxito
    header("Location: ../index.php?compra=exitosa");
    exit();
} 