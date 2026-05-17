<?php
session_start();
if(!isset($_SESSION['id_usuario'])) { header("Location: login.php"); exit(); }
include 'config/conexion.php';

$id_u = $_SESSION['id_usuario'];

// 1. Verificar si el usuario ya es PRO (ha pagado los $369.00)
$check_pago = mysqli_query($conexion, "SELECT * FROM ventas WHERE id_usuario = $id_u AND estado_pago = 'Completado'");
$es_pro = mysqli_num_rows($check_pago) > 0;

// Marcamos como vistas (puedes ajustar esta lógica según tu necesidad)
mysqli_query($conexion, "UPDATE receta SET visto = 1 WHERE id_usuario = $id_u");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Recetas - TERVI</title>
    <link rel="stylesheet" href="assets/css/historialC.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-medical" style="margin-top: 100px;">
        <h1 style="color: #2e86c1; margin-bottom: 10px;">💊 Mis Recetas y Tratamientos</h1>
        <p style="margin-bottom: 30px; color: #666;">
            <?= $es_pro ? '🟢 Plan Pro Activo: Acceso Total' : '🔵 Plan Freemium: Límite de 3 recetas' ?>
        </p>

        <div class="card-medical">
           <table class="medical-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Indicación / Observacion</th>
                <th>Doctor</th>
                <th>Repeticiones</th>
                <th>Ejercicio</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $res = mysqli_query($conexion, "SELECT * FROM receta WHERE id_usuario = $id_u ORDER BY fecha DESC");
            $contador = 0;
            
            if(mysqli_num_rows($res) > 0){
                while($r = mysqli_fetch_assoc($res)){ 
                    $contador++;
                    // Si no es PRO y ya vio 3, bloqueamos el contenido
                    $bloqueado = (!$es_pro && $contador > 3);
            ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                        <td>
                            <?php if ($bloqueado): ?>
                                <span style="filter: blur(4px); user-select: none;">OBSERVACIÓN BLOQUEADA POR PLAN GRATUITO</span>
                                <br>
                                <a href="pago.php" style="color: #D4AF37; font-size: 0.8rem; font-weight: bold; text-decoration: none;">
                                    <i class="fas fa-lock"></i> Suscríbete para ver esta receta
                                </a>
                            <?php else: ?>
                                <strong><?= nl2br(htmlspecialchars($r['observacion'])) ?></strong>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $bloqueado ? '---' : htmlspecialchars($r['nombre_doctor']) ?>
                        </td>
                        <td>
                            <?= $bloqueado ? '---' : $r['repeticiones'] ?>
                        </td>
                        <td>
                            <?= $bloqueado ? '---' : htmlspecialchars($r['id_ejercicio']) ?>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding:50px; color:#999;'>No se han encontrado recetas vinculadas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>

        <?php if ($es_pro): ?>
            <button onclick="prepararImpresion()" class="btn-med btn-blue" style="margin-top: 20px;">
                <i class="fas fa-download"></i> Descargar Receta Oficial (PDF)
            </button>
        <?php else: ?>
            <div style="background: #fff8e1; border: 1px solid #ffe082; padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center;">
                <p style="margin: 0; font-size: 0.9rem;">
                    🔒 La descarga de recetas oficiales está reservada para usuarios <strong>TERVI Pro</strong>.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function prepararImpresion() { window.print(); }
    </script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>