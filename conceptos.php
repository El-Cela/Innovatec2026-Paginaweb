<?php 
include 'includes/header.php'; 
// Simulación de conexión 
$conexion = mysqli_connect("localhost", "root", "", "rv_rehabilitacion");
$query_conceptos = mysqli_query($conexion, "SELECT * FROM contenidos WHERE tipo_contenido = 'Concepto' ORDER BY id_contenido ASC");
$query_info = mysqli_query($conexion, "SELECT * FROM contenidos WHERE tipo_contenido = 'Guía' ORDER BY id_contenido ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERVI - Centro de Aprendizaje Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/conceptos.css">
</head>
<body>

<section class="hero-section">
    <h1>Centro de Aprendizaje</h1>
    <p>Explora nuestras guías interactivas y glosario médico diseñado para tu evolución.</p>
</section>

<div class="container">
    <div style="text-align: center; margin-bottom: 80px;">
        <span style="color: var(--dorado); font-weight: 800; letter-spacing: 3px;">REHABILITACIÓN TERVI</span>
        <h2 style="font-size: 2.5rem; font-weight: 900; color: var(--azul-tervi); margin: 10px 0;">GUÍAS DE ESPECIALIDAD</h2>
        <div style="width: 80px; height: 4px; background: var(--verde-salud); margin: 20px auto;"></div>
    </div>

    <?php 
    $contador = 0;
    while($i = mysqli_fetch_assoc($query_info)): 
        // 1. Lógica de validación
        $ruta_img = 'assets/img/' . $i['imagen_url'];
        
        if (!empty($i['imagen_url']) && file_exists($ruta_img)) {
            $img_final = $ruta_img;
            $usa_icono = false;
        } else {
            $img_final = ""; 
            $usa_icono = true;
        }
    ?>
    <div class="guia-row">
        <div class="guia-visual">
            <?php if ($usa_icono): ?>
                <div class="guia-img no-foto">🦾</div>
            <?php else: ?>
                <div class="guia-img" style="background-image: url('<?= $img_final ?>');"></div>
            <?php endif; ?> 
        </div>

        <div class="guia-contenido">
            <span>Módulo 0<?php echo $contador + 1; ?></span>
            <h2><?php echo htmlspecialchars($i['titulo']); ?></h2>
            <p><?php echo nl2br($i['descripcion']); ?></p>
        </div>
    </div>
    <?php $contador++; endwhile; ?>
</div>

<section class="glosario-container">
    <div class="glosario-header">
        <h2>🧠 Glosario Rápido</h2>
        <p style="color: var(--texto-p);">Conceptos clave explicados de forma sencilla para tu día a día.</p>
    </div>

    <div class="grid-conceptos">
        <?php while($c = mysqli_fetch_assoc($query_conceptos)): ?>
        <article class="concepto-card">
            <h3><?php echo htmlspecialchars($c['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($c['descripcion']); ?></p>
        </article>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>