<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TERVI - Apoyo Integral en Amputaciones</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-content">
                <span class="hero-subtitle">Especialistas en movilidad y adaptación</span>
                <h1>Tu nueva etapa <br>comienza hoy</h1>
                <p>Acompañamos tu proceso de rehabilitación con guías diseñadas para recuperar tu independencia y mejorar tu calidad de vida.</p>
                <div class="hero-buttons">
                    <a href="ejercicios.php" class="btn-primary">Ejercicios de Adaptación</a>
                    <a href="sobre-nosotros.php" class="btn-outline">Nuestra Misión</a>
                </div>
            </div>
        </section>

        <section class="info-grid">
            <div class="info-card">
                <h3>Atención Directa</h3>
                <ul class="schedule">
                    <li>Consulta Online <span>9:00 - 18:00</span></li>
                    <li>Soporte Técnico <span>24/7</span></li>
                    <li>Grupos de Apoyo <span>Jueves 17:00</span></li>
                </ul>
            </div>
            
            <div class="info-card highlight">
                <h3>Guía de Cuidados</h3>
                <p>Aprende técnicas fundamentales para el cuidado del muñón, vendaje compresivo y preparación para la prótesis.</p>
                <a href="conceptos.php" class="btn-link">Ver Guías de Cuidado →</a>
            </div>

            <div class="info-card">
                <h3>Asistente TERVI</h3>
                <p>¿Tienes dudas sobre tu rutina o el uso de tu dispositivo? Nuestro chatbot está listo para escucharte.</p>
                <button class="btn-primary" id="btn-chat" onclick="toggleChat()">Hablar con TERVI</button>
            </div>
        </section>

        <section class="services">
            <div class="container">
                <h2 class="section-title">Áreas de Acompañamiento</h2>
                <div class="services-container">
                    <div class="service-item">
                        <img src="/assets/img/attractive-person-with-disability-doing-sports-park-mid-adult-sportsman-skateboarding-down-special-road-concentration-sport-disability-training-concept.jpg" alt="Prótesis">
                        <h4>Uso de Prótesis</h4>
                        <p>Técnicas de colocación, alineación y primeros pasos con tu dispositivo.</p>
                    </div>
                    <div class="service-item">
                        <img src="/assets/img/trainer-helping-woman-recovering-after-coronavirus-fitness-ball.jpg" alt="Equilibrio">
                        <h4>Fortalecimiento</h4>
                        <p>Ejercicios para mejorar el equilibrio y fortalecer el core y extremidades.</p>
                    </div>
                    <div class="service-item">
                        <img src="/assets/img/close-up-doctor-checking-bandaged-arm.jpg" alt="Piel">
                        <h4>Cuidado Integral</h4>
                        <p>Higiene y prevención de lesiones en la piel y tejidos sensibles.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-banner">
            <div class="cta-content">
                <h2>No estás solo en este camino</h2>
                <p>Accede a testimonios y videos de rehabilitación diseñados por expertos en movilidad.</p>
                <a href="videos.php" class="btn-secondary">Explorar Videoteca</a>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>