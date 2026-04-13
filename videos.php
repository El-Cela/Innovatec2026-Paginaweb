<?php 
include 'includes/header.php'; 
include 'config/conexion.php'; 

// Capturamos el video seleccionado (si no hay, mostramos el último subido)
$id_video = isset($_GET['v']) ? intval($_GET['v']) : 0;

if ($id_video > 0) {
    $res = mysqli_query($conexion, "SELECT * FROM videos WHERE id_video = $id_video");
    $video_actual = mysqli_fetch_assoc($res);
} else {
    $res = mysqli_query($conexion, "SELECT * FROM videos ORDER BY id_video DESC LIMIT 1");
    $video_actual = mysqli_fetch_assoc($res);
}
?>

<link rel="stylesheet" href="assets/css/videos.css">

<section class="hero-section">
    <h1>Centro de Videoterapia</h1>
    <p>Aprende de los expertos con nuestras guías visuales de rehabilitación.</p>
</section>

<div class="container video-layout">
    
    <main class="video-main">
        <?php if ($video_actual): ?>
            <div class="video-player-container">
    <?php 
        // 1. Usamos el nombre real de la columna: url_youtube
        $url = $video_actual['url_youtube']; 
        
        // 2. Convertimos formato normal a Embed
        $embed = str_replace("watch?v=", "embed/", $url);
        
        // 3. ¡Extra! Por si usas links cortos (youtu.be/...)
        $embed = str_replace("youtu.be/", "www.youtube.com/embed/", $embed);

        // 4. Limpiamos cualquier parámetro extra (como &t=10s o &ab_channel)
        $posicion_extra = strpos($embed, '&');
        if ($posicion_extra !== false) {
            $embed = substr($embed, 0, $posicion_extra);
        }
    ?>
    <iframe width="100%" height="450" src="<?= $embed ?>" frameborder="0" allowfullscreen></iframe>
</div>

            <div class="video-info">
                <h2><?= htmlspecialchars($video_actual['titulo_video']) ?></h2>
                <span class="duracion">⏱ Duración: <?= $video_actual['duracion_minutos'] ?> min</span>
            </div>

            <div class="comments-section">
                <h3>💬 Comunidad TERVI</h3>
                
                <form action="procesos/guardar_comentario.php" method="POST" class="comment-form">
                    <input type="hidden" name="id_video" value="<?= $video_actual['id_video'] ?>">
                    <div class="form-group">
                    <input type="text" name="nombre_usuario" placeholder="Tu nombre o alias..." required 
               style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #d6eaf8; margin-bottom: 10px;">
                      </div>
                    <textarea name="comentario" placeholder="Escribe tu duda o comentario aquí..." required></textarea>
                    <button type="submit" name="enviar_comentario" class="btn-submit-comment">
                      <span>Publicar Comentario</span>
                      <i class="fas fa-paper-plane"></i> <span style="margin-left: 8px;">🚀
                      </span> 
                       </button>                
                    </form>

                <div class="comments-list">
                    <?php 
                    $id_v = $video_actual['id_video'];
                    $coms = mysqli_query($conexion, "SELECT * FROM comentarios WHERE id_video = $id_v AND estado = 'aprobado' ORDER BY fecha DESC");
                    while($c = mysqli_fetch_assoc($coms)): 
                    ?>
                        <div class="comment-card">
                        <h4 style="margin: 0 0 5px 0; color: var(--azul-oscuro); font-size: 0.9rem;">
                         👤 <?= htmlspecialchars($c['nombre_usuario']) ?> dice:</h4>
                         <p><?= htmlspecialchars($c['comentario']) ?></p>
                         <small>📅 <?= date('d/m/Y', strtotime($c['fecha'])) ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else: ?>
            <p>Aún no hay videos disponibles.</p>
        <?php endif; ?>
    </main>

    <aside class="video-sidebar">
        <h3>📹 Más Videos</h3>
        <div class="playlist">
            <?php 
            $lista = mysqli_query($conexion, "SELECT * FROM videos ORDER BY id_video DESC");
            while($lv = mysqli_fetch_assoc($lista)): 
            ?>
                <a href="videos.php?v=<?= $lv['id_video'] ?>" class="playlist-item <?= $id_video == $lv['id_video'] ? 'active' : '' ?>">
                    <div class="thumb-mini">▶</div>
                    <div class="info-mini">
                        <h4><?= htmlspecialchars($lv['titulo_video']) ?></h4>
                        <small><?= $lv['duracion_minutos'] ?> min</small>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </aside>

</div>

<?php include 'includes/footer.php'; ?>