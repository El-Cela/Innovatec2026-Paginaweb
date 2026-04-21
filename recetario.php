<?php
session_start();
include 'config/conexion.php';
$id = $_SESSION['id_usuario'];
mysqli_query($conexion, "UPDATE recetario SET visto = 1 WHERE id_usuario = " . $_SESSION['id_usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Recetas </title>
    <link rel="stylesheet" href="assets/css/historialC.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-medical">
    <h1 style="color: #2e86c1; margin-bottom: 30px;">💊 Mis Recetas y Tratamientos</h1>
    <div class="card-medical">
       <table class="medical-table">
    <thead>
        <tr>
            <th style="border-bottom: 2px solid #333;">Fecha</th>
            <th style="border-bottom: 2px solid #333;">Indicación / Medicamento</th>
            <th style="border-bottom: 2px solid #333;">Doctor</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $id_u = $_SESSION['id_usuario'];
        $res = mysqli_query($conexion, "SELECT * FROM recetario WHERE id_usuario = $id_u ORDER BY fecha DESC");
        
        if(mysqli_num_rows($res) > 0){
            while($r = mysqli_fetch_assoc($res)){ ?>
                <tr>
                    <td style="font-family: 'Courier New', monospace;"><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                    <td style="font-family: 'Courier New', monospace;"><strong><?= nl2br(htmlspecialchars($r['indicacion'])) ?></strong></td>
                    <td style="font-family: 'Courier New', monospace; color: #2e86c1;"><?= htmlspecialchars($r['nombre_doctor']) ?></td>
                </tr>
            <?php }
        } else {
            echo "<tr><td colspan='3' style='text-align:center; padding:50px; color:#999;'>No se han encontrado recetas vinculadas.</td></tr>";
        }
        ?>
    </tbody>
</table>
    </div>
</div>

<button onclick="prepararImpresion()" class="btn-med btn-blue">
    <i class="fas fa-download"></i> Descargar Receta Oficial (PDF)
</button>

<script>
function prepararImpresion() {
    // Esto oculta el resto de la página y solo deja la "hoja de papel"
    window.print();
}
</script>
