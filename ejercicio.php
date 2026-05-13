<?php 
include 'includes/header.php'; 
include 'config/conexion.php'; 
include 'includes/funciones.php';

// 1. Traemos las categorías de la tabla 'categorias'
$res_categorias = mysqli_query($conexion, "SELECT * FROM categorias ORDER BY id_categoria ASC");

// Validación para evitar el Fatal Error si la tabla no existe o está vacía
if (!$res_categorias) {
    die("<div style='padding:20px; background:#fee; color:#b00;'>Error en base de datos: " . mysqli_error($conexion) . "</div>");
}

$categorias_db = [];
while($row = mysqli_fetch_assoc($res_categorias)) {
    $categorias_db[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/ejercicio.css">
    <title>TERVI | Gimnasio Terapéutico</title>
    <style>
        /* Estilos restaurados */
        .filter-container { text-align: center; margin-bottom: 40px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .filter-btn { padding: 10px 20px; border: 2px solid var(--azul-tervi); background: transparent; color: var(--azul-tervi); border-radius: 25px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .filter-btn.active, .filter-btn:hover { background: var(--azul-tervi); color: white; }
        .categoria-section { display: none; }
        .categoria-section.active { display: block; }
        
        /* Badges de dificultad para las cards */
        .badge.Bajo { background: #27ae60; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; }
        .badge.Medio { background: #f39c12; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; }
        .badge.Alto { background: #e74c3c; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; }
    </style>
</head>
<body>
<section class="hero-section">
    <h1>Gimnasio Terapéutico</h1>
    <p>Medicina de precisión para pacientes con padecimientos musculoesqueléticos o post-quirúrgicos.</p>
</section>

<div class="container">
    <div style="text-align: center; margin-bottom: 30px;">
        <span style="color: var(--dorado); font-weight: 800; letter-spacing: 3px; text-transform: uppercase;">Entrenamiento TERVI</span>
        <h2 style="font-size: 2.2rem; font-weight: 900; color: var(--azul-tervi); margin: 10px 0;">CATÁLOGO POR ESPECIALIDAD</h2>
        <div style="width: 60px; height: 4px; background: var(--verde-salud); margin: 20px auto;"></div>
    </div>

    <div class="filter-container">
        <button class="filter-btn active" onclick="mostrarCategoria('all', this)">Todos</button>
        <?php foreach($categorias_db as $cat): 
            $cat_slug = strtolower(str_replace(['/', ' '], '-', $cat['nombre']));
        ?>
            <button class="filter-btn" onclick="mostrarCategoria('<?= $cat_slug ?>', this)">
                <?= $cat['nombre'] ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div id="ejercicios-container">
    <?php 
    foreach($categorias_db as $cat): 
        $cat_id_actual = $cat['id_categoria'];
        $cat_slug = strtolower(str_replace(['/', ' '], '-', $cat['nombre']));
        
        // Consulta filtrada por el ID de la tabla categoria
        $query = mysqli_query($conexion, "SELECT * FROM series_ejercicio WHERE id_categoria = '$cat_id_actual' ORDER BY nivel_dificultad DESC");
    ?>
        <div class="categoria-section all <?= $cat_slug ?> active">
            <h3 style="color: var(--azul-tervi); border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 40px;">
                <i class="fas fa-stethoscope"></i> Rutinas: <?= $cat['nombre'] ?>
            </h3>
            
            <div class="grid-conceptos">
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($e = mysqli_fetch_assoc($query)): ?>
                    <article class="concepto-card">
                        <div class="card-header">
                            <span class="badge <?= $e['nivel_dificultad'] ?>">
                                <?= htmlspecialchars($e['nivel_dificultad']) ?>
                            </span>
                            <span style="font-size: 0.8rem; color: #95a5a6; font-weight: 600;">
                                📅 <?= htmlspecialchars($e['frecuencia']) ?>
                            </span>
                        </div>
                        
                        <h3><?= htmlspecialchars($e['nombre']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($e['descripcion'])) ?></p>

                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-val"><?= $e['series'] ?></span>
                                <small>Series</small>
                            </div>
                            <div class="stat-item">
                                <span class="stat-val"><?= $e['repeticiones'] ?></span>
                                <small>Reps</small>
                            </div>
                        </div>

                        <?php if(!empty($e['precauciones'])): ?>
                            <div class="precaucion-box">
                                <strong>⚠️ Seguridad TERVI:</strong>
                                <?= htmlspecialchars($e['precauciones']) ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #999; font-style: italic; padding: 20px;">Próximamente ejercicios de <?= $cat['nombre'] ?> en Realidad Virtual.</p>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<script>
function mostrarCategoria(clase, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const secciones = document.querySelectorAll('.categoria-section');
    secciones.forEach(sec => {
        if (clase === 'all') {
            sec.classList.add('active');
        } else {
            if (sec.classList.contains(clase)) {
                sec.classList.add('active');
            } else {
                sec.classList.remove('active');
            }
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>