<?php 
session_start(); // Paso 1: ¡Fundamental para saber quién está navegando!
include 'includes/header.php'; 
include 'config/conexion.php'; 

$id_video = isset($_GET['v']) ? intval($_GET['v']) : 0;
$res = ($id_video > 0) ? 
    mysqli_query($conexion, "SELECT * FROM videos WHERE id_video = $id_video") : 
    mysqli_query($conexion, "SELECT * FROM videos ORDER BY id_video DESC LIMIT 1");
$video_actual = mysqli_fetch_assoc($res);
?>

<link rel="stylesheet" href="assets/css/videos.css">

<section class="hero-section">
    <h1>Centro de Videoterapia</h1>
    <p>Guías visuales de rehabilitación para pacientes de MinndTeen.</p>
</section>

<div class="container video-layout">
    <main class="video-main">
        <?php if ($video_actual): ?>
            <div class="video-player-container">
                <?php 
                    $url = $video_actual['url_youtube']; 
                    $embed = str_replace(["watch?v=", "youtu.be/"], ["embed/", "www.youtube.com/embed/"], $url);
                    $pos = strpos($embed, '&');
                    if ($pos !== false) $embed = substr($embed, 0, $pos);
                ?>
                <iframe width="100%" height="450" src="<?= $embed ?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="video-info">
                <h2><?= htmlspecialchars($video_actual['titulo_video']) ?></h2>
                <span class="duracion">⏱ Duración: <?= $video_actual['duracion_minutos'] ?> min</span>
            </div>

            <div class="comments-section">
                <h3>💬 Comunidad TERVI</h3>
                
                <?php if(isset($_SESSION['id_usuario'])): ?>
                    <form action="procesos/guardar_comentario.php" method="POST" class="comment-form">
                        <input type="hidden" name="id_video" value="<?= $video_actual['id_video'] ?>">
                        
                        <p style="color: var(--azul-tervi); font-weight: bold; margin-bottom: 10px;">
                            👤 Estás comentando como: <?= $_SESSION['nombre_usu'] ?>
                        </p>

                        <textarea name="comentario" placeholder="Escribe tu duda aquí..." required></textarea>
                        <button type="submit" name="enviar_comentario" class="btn-submit-comment">
                            Publicar Comentario 🚀
                        </button>                
                    </form>
                <?php else: ?>
                    <div style="background: #fdf2e9; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #fae5d3;">
                        <p>Para dejar una duda o comentario, necesitas una cuenta.</p>
                        <a href="login.php" style="color: var(--azul-tervi); font-weight: bold; text-decoration: underline;">Iniciar Sesión</a> o 
                        <a href="registro.php" style="color: var(--azul-tervi); font-weight: bold; text-decoration: underline;">Registrarse</a>
                    </div>
                <?php endif; ?>

                <div class="comments-list">
                    <?php 
                    $id_v = $video_actual['id_video'];
                    $coms = mysqli_query($conexion, "SELECT * FROM comentarios WHERE id_video = $id_v AND estado = 'aprobado' ORDER BY fecha DESC");
                    while($c = mysqli_fetch_assoc($coms)): 
                    ?>
                        <div class="comment-card">
                            <h4 style="margin:0; color:var(--azul-tervi);">👤 <?= htmlspecialchars($c['nombre_usuario']) ?></h4>
                            <p><?= htmlspecialchars($c['comentario']) ?></p>
                            <small>📅 <?= date('d/m/Y', strtotime($c['fecha'])) ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <aside class="video-sidebar">
        </aside>
</div>

<?php include 'includes/footer.php'; ?>