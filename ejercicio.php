<?php 
include 'includes/header.php'; 
include 'config/conexion.php'; 

// Traemos todos los ejercicios de la tabla correcta
$query_ejercicios = mysqli_query($conexion, "SELECT * FROM ejercicio ORDER BY nivel_dificultad DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/ejercicio.css">
    <title>TERVI | Ejercicios</title>
</head>
<body>
<section class="hero-section">
    <h1>Gimnasio Terapéutico</h1>
    <p>Rutinas de rehabilitación diseñadas para fortalecer tu cuerpo y acelerar tu recuperación paso a paso.</p>
</section>

<div class="container">
    <div style="text-align: center; margin-bottom: 60px;">
        <span style="color: var(--dorado); font-weight: 800; letter-spacing: 3px; text-transform: uppercase;">Entrenamiento TERVI</span>
        <h2 style="font-size: 2.2rem; font-weight: 900; color: var(--azul-tervi); margin: 10px 0;">CATÁLOGO DE ACTIVIDADES</h2>
        <div style="width: 60px; height: 4px; background: var(--verde-salud); margin: 20px auto;"></div>
    </div>

    <div class="grid-conceptos">
    <?php while($e = mysqli_fetch_assoc($query_ejercicios)): ?>
        <article class="concepto-card">
            <div class="card-header">
                <span class="badge <?= $e['nivel_dificultad'] ?>">
                    <?= htmlspecialchars($e['nivel_dificultad']) ?>
                </span>
                <span style="font-size: 0.8rem; color: #95a5a6; font-weight: 600;">
                    📅 <?= htmlspecialchars($e['frecuencia']) ?>
                </span>
            </div>

            <?php 
            // Verificamos si la imagen existe en la base de datos y en la carpeta física
            $ruta_imagen = "assets/img/ejercicios/" . $e['imagen_guia'];
            if(!empty($e['imagen_guia']) && file_exists($ruta_imagen)): 
            ?>
                <div class="ejercicio-img-container">
                    <img src="<?= $ruta_imagen ?>" alt="<?= htmlspecialchars($e['nombre']) ?>" class="ejercicio-foto">
                </div>
            <?php else: ?>
                <div style="margin-top: 20px; border-top: 1px solid #eee;"></div>
            <?php endif; ?>
            <h3><?= htmlspecialchars($e['nombre']) ?></h3>
            
            <p><?= nl2br(htmlspecialchars($e['descripcion'])) ?></p>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-val"><?= $e['series'] ?></span>
                    <span class="stat-label">Series</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val"><?= $e['repeticiones'] ?></span>
                    <span class="stat-label">Reps</span>
                </div>
            </div>

            <?php if(!empty($e['precauciones'])): ?>
                <div class="precaucion-box">
                    <strong>⚠️ Recomendación:</strong>
                    <?= htmlspecialchars($e['precauciones']) ?>
                </div>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>