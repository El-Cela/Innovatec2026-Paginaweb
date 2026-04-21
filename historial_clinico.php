<?php
session_start();
if(!isset($_SESSION['id_usuario'])) { header("Location: login.php"); exit(); }
include 'config/conexion.php';

$id = $_SESSION['id_usuario'];
$res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = $id");
$u = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Historial</title>
    <link rel="stylesheet" href="assets/css/historialC.css"> </head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-medical">
    <div class="card-medical">
        <h1>📄 Historial Clínico Digital</h1>
        <div class="info-grid">
            <div class="info-item">
                <strong>Paciente</strong>
                <span><?= htmlspecialchars($u['nombre'] . " " . $u['apellido_paterno']) ?></span>
            </div>
            <div class="info-item">
                <strong>Edad</strong>
                <span><?= $u['edad'] ?> años</span>
            </div>
            <div class="info-item">
                <strong>Peso</strong>
                <span><?= $u['peso'] ?> kg</span>
            </div>
            <div class="info-item">
                <strong>Altura</strong>
                <span><?= $u['altura'] ?> cm</span>
            </div>
            <div class="info-item">
                <strong>IMC</strong>
                <span class="imc-badge">
                    <?php 
                        $altura_m = $u['altura'] / 100;
                        echo round($u['peso'] / ($altura_m * $altura_m), 1);
                    ?>
                </span>
            </div>
        </div>
    </div>
    
    <div class="card-medical">
        <h3>🩺 Evolución Médica</h3>
        <div style="text-align: center; padding: 40px; color: #aab7b8;">
            <i class="fas fa-microscope" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
            <p>No hay notas médicas registradas en su expediente aún.</p>
        </div>
    </div>
</div>
    <?php include 'includes/footer.php'; ?>