<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TERVI</title>
   <link rel="stylesheet" href="/assets/css/estilos.css">
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
                    <li><a href="/conceptos.php">Conceptos <i class="arrow down"></i></a></li>
                    <li><a href="/videos.php">Recursos <i class="arrow down"></i></a></li>
                    <li><a href="/ejercicio.php">Ejercicios <i class="arrow down"></i></a></li>
                    <li><a href="/sobre_nosotros.php">Acerca de <i class="arrow down"></i></a></li>
                </ul>
            </nav>
        </div> 
    </header>
    <script>
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
</script>
    </body>