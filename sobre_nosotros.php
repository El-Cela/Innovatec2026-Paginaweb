<?php include 'includes/header.php'; ?>

<style>
    :root {
        --azul-oscuro: #16425B;    /* Títulos y botones */
        --azul-medio: #81B2D2;     /* Acentos y bordes */
        --celeste-claro: #C1E3F4;  /* Fondos suaves */
        --crema: #F3D5B5;          /* Detalles cálidos / Hover */
        --blanco-fondo: #F8F9FA;   /* Fondo general */
        --texto: #333333;          /* Cuerpo de texto */
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--blanco-fondo);
        color: var(--texto);
        margin: 0;
        line-height: 1.6;
    }

    .contenedor-principal-limpio {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 20px;
    }

    /* --- SECCIÓN INTRO --- */
    .intro-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        margin-bottom: 100px;
    }

    .badge-informate {
        background-color: var(--celeste-claro);
        color: var(--azul-oscuro);
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        font-weight: bold;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .intro-texto h2 {
        font-size: 2.8rem;
        color: var(--azul-oscuro);
        margin-bottom: 25px;
        line-height: 1.2;
    }

    .intro-texto p {
        font-size: 1.1rem;
        color: var(--texto);
        margin-bottom: 20px;
    }

    .intro-imagen img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(22, 66, 91, 0.1);
        border: 4px solid white;
    }

    /* --- SECCIÓN EQUIPO --- */
    .seccion-nosotras {
        text-align: center;
        background: white;
        padding: 60px 40px;
        border-radius: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .seccion-nosotras h3 {
        color: var(--azul-oscuro);
        margin-bottom: 40px;
        font-size: 2.2rem;
    }

    .equipo-flex {
        display: flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .card-programadora {
        background: var(--blanco-fondo);
        padding: 40px;
        border-top: 5px solid var(--crema); /* Detalle cálido arriba */
        border-radius: 20px;
        width: 280px;
        transition: all 0.3s ease;
    }

    .card-programadora:hover {
        transform: translateY(-10px);
        background-color: white;
        box-shadow: 0 15px 30px rgba(129, 178, 210, 0.2);
        border-top-color: var(--azul-medio);
    }

    .card-programadora p {
        margin: 0 0 10px 0;
        font-size: 1.4rem;
        color: var(--azul-oscuro);
        font-weight: bold;
    }

    .card-programadora span {
        font-size: 1rem;
        color: var(--azul-medio);
        font-weight: 600;
    }

    @media (max-width: 900px) {
        .intro-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        .intro-imagen { order: 1; }
        .intro-texto { order: 2; }
    }
</style>

<main class="contenedor-principal-limpio">
    <section class="seccion-intro">
        <div class="intro-grid">
            <div class="intro-texto">
                <span class="badge-informate">¿Qué es MindTeen?</span>
                <h2>Nuestra Misión: Tu paz mental es nuestra prioridad</h2>
                <p>Somos una plataforma diseñada para adolescentes que buscan respuestas y alivio ante el estrés y la ansiedad cotidiana. A través de nuestro 
                "Diccionario Visual", videos educativos y una comunidad de apoyo, buscamos desmitificar los trastornos de ansiedad.
                Desarrollado con dedicación por nuestro equipo de programación, MindTeen combina la tecnología con estrategias 
                psicológicas sencillas para brindarte un refugio digital de calma y aprendizaje.
                </p>
            </div>
            <div class="intro-imagen">
                <img src="img/6.png" alt="Apoyo en salud mental">
            </div>
        </div>
    </section>

    <section class="seccion-nosotras">
        <h3>Nuestro Equipo de Desarrollo</h3>
        <div class="equipo-flex">
            <div class="card-programadora">
                <p>Olga Mercedes</p>
                <span>Desarrolladora Backend & DB, Desarrolladora Frontend & Diseño</span>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>