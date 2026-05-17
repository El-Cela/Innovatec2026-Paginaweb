<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Asegúrate de tener la conexión a la BD disponible aquí
include_once 'config/conexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TERVI</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="main-nav">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">
                    <span class="logo-icon"><img src="img/mental-health.png" alt=""></span> 
                    <strong>TER<span>VI</span></strong>
                </a>
            </div>

            <button class="menu-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <nav class="menu" id="nav-menu">
                <ul>
                    <li><a href="/conceptos.php">Conceptos</a></li>
                    <li><a href="/videos.php">Recursos</a></li>
                    <li><a href="/ejercicio.php">Ejercicios</a></li>
                    <li><a href="/sobre_nosotros.php">Acerca de</a></li>

                    <?php if(isset($_SESSION['id_usuario'])): 
                        // Lógica de notificaciones
                        $id_u = $_SESSION['id_usuario'];
                        $notif = mysqli_query($conexion, "SELECT COUNT(*) as nuevas FROM receta WHERE id_usuario = $id_u AND visto = 0");
                        $n = mysqli_fetch_assoc($notif);
                    ?>
                        <li class="nav-especial">
                            <a href="#" class="perfil-usuario">
                                <i class="fas fa-user-circle"></i> MI SALUD
                                <?php if($n['nuevas'] > 0): ?>
                                    <span style="background:red; color:white; border-radius:50%; padding:2px 6px; font-size:10px; margin-left: 5px;">
                                        <?= $n['nuevas'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <ul class="sub-menu-salud">
                                <li><a href="historial_clinico.php"><i class="fas fa-file-medical"></i> HISTORIAL</a></li>
                                <li><a href="recetario.php"><i class="fas fa-pills"></i> RECETA</a></li>
                                <li><a href="puntuacion.php"><i class="fas fa-star"></i> PUNTUACIONES</a></li>
                                <li><a href="procesos/logout.php" class="link-salir"><i class="fas fa-sign-out-alt"></i> SALIR</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Ingresar</a></li>
                    <?php endif; ?>

                    <li class="buy-item">
                        <a href="checkout.php" class="btn-buy">Adquirir Software 💎</a>
                    </li>
                </ul>
            </nav>
        </div> 
    </header>

<script>
// Lógica para el botón Hamburguesa
const mobileMenu = document.getElementById('mobile-menu');
const navMenu = document.getElementById('nav-menu');

if (mobileMenu && navMenu) {
    mobileMenu.addEventListener('click', () => {
        // Alterna la clase 'active' tanto en el botón como en el menú
        mobileMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
}

// Lógica para el submenú "MI SALUD" (Tu código existente optimizado)
const navEspecial = document.querySelector('.nav-especial');
const btnSalud = document.querySelector('.perfil-usuario');
const subMenu = document.querySelector('.sub-menu-salud');

if (btnSalud && subMenu) {
    btnSalud.addEventListener('click', (e) => {
        e.preventDefault();
        subMenu.classList.toggle('mostrar-menu');
    });

    document.addEventListener('click', (e) => {
        if (navEspecial && !navEspecial.contains(e.target)) {
            subMenu.classList.remove('mostrar-menu');
        }
    });
}
</script>