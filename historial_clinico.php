<?php
session_start();
if(!isset($_SESSION['id_usuario'])) { header("Location: login.php"); exit(); }
include 'config/conexion.php';

$id = $_SESSION['id_usuario'];
// Verificamos si el usuario ya realizó su pago de $369.00
$check_pago = mysqli_query($conexion, "SELECT * FROM ventas WHERE id_usuario = $id AND estado_pago = 'Completado'");
$ha_pagado = mysqli_num_rows($check_pago) > 0;

$res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = $id");
$u = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Historial - TERVI</title>
    <link rel="stylesheet" href="assets/css/historialC.css">
    <!-- Iconos para mejorar la vista -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-medical" style="margin-top: 100px;">
        
        <!-- PARTE GRATUITA: Datos Básicos -->
        <div class="card-medical">
            <h1>📄 Historial Clínico Digital</h1>
            <p style="font-size: 0.8rem; color: #7f8c8d;">ID Paciente: #<?= $u['id_usuario'] ?></p>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Paciente</strong>
                    <span><?= htmlspecialchars($u['nombre_usu'] . " " . $u['apellidoP_usu']) ?></span>
                </div>
                <div class="info-item">
                    <strong>Edad</strong>
                    <span><?= $u['edad_usu'] ?> años</span>
                </div>
                <div class="info-item">
                    <strong>Peso</strong>
                    <span><?= $u['peso_usu'] ?> kg</span>
                </div>
                <div class="info-item">
                    <strong>Altura</strong>
                    <span><?= $u['altura_usu'] ?> cm</span>
                </div>
                <div class="info-item">
                    <strong>IMC</strong>
                    <span class="imc-badge">
                        <?php 
                            $altura_m = $u['altura_usu'] / 100;
                            echo round($u['peso_usu'] / ($altura_m * $altura_m), 1);
                        ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- PARTE BLOQUEADA/PRO: Evolución Médica -->
        <div class="card-medical" style="position: relative; overflow: hidden;">
            <h3><i class="fas fa-chart-line"></i> Evolución Médica y Biomecánica</h3>
            
            <?php if (!$ha_pagado): ?>
                <!-- Overlay de Bloqueo para motivar la suscripción SaaS -->
                <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.9); border-radius: 15px;">
                    <i class="fas fa-lock" style="font-size: 3rem; color: #2e86c1; margin-bottom: 15px;"></i>
                    <h4>Contenido Exclusivo TERVI Pro</h4>
                    <p style="max-width: 400px; margin: 0 auto 20px auto; color: #555;">
                        Para visualizar tus reportes de precisión, gráficas de recuperación y análisis de sensores 6DoF, adquiere tu suscripción.[cite: 1]
                    </p>
                    <a href="pago.php" style="background: #D4AF37; color: black; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: bold; display: inline-block;">
                        DESBLOQUEAR POR $369.00 MXN
                    </a>
                </div>
            <?php else: ?>
                <!-- Contenido que verá solo si ya pagó -->
                <div style="text-align: center; padding: 40px; color: #2ecc71;">
                    <i class="fas fa-microscope" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p><strong>Ecosistema Activo:</strong> Sus datos biomecánicos se están sincronizando con el visor de Realidad Virtual.[cite: 1]</p>
                    <p style="color: #7f8c8d;">No hay notas médicas registradas en su expediente aún.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>