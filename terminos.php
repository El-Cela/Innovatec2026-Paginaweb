<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
?>

<style>
    /* Estilos específicos para la sección legal */
    .legal-container {
        max-width: 900px;
        margin: 120px auto 50px;
        padding: 0 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .legal-card {
        background: white;
        padding: 50px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 8px solid #2e86c1;
        line-height: 1.6;
        color: #444;
    }

    .legal-card h1 {
        color: #2e86c1;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 30px;
        font-size: 1.8rem;
    }

    .legal-card h2 {
        color: #2c3e50;
        font-size: 1.3rem;
        margin-top: 25px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }

    .legal-card p {
        margin-bottom: 15px;
        text-align: justify;
    }

    .legal-card ul {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .legal-card ul li {
        margin-bottom: 8px;
    }

    .footer-legal {
        text-align: center;
        margin-top: 30px;
        font-size: 0.9rem;
        color: #95a5a6;
    }

    .btn-regresar {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: #2e86c1;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-regresar:hover {
        background: #21618c;
    }
</style>

<div class="legal-container">
    <div class="legal-card">
        <h1>Términos y Condiciones de Uso</h1>
        <p><strong>Última actualización:</strong> <?= date('d/m/Y') ?></p>

        <p>Bienvenido a <strong>TERVI</strong>. Al utilizar nuestra plataforma de rehabilitación virtual, usted acepta cumplir con los siguientes términos y condiciones diseñados para garantizar un entorno seguro y profesional.</p>

        <h2>1. Naturaleza del Servicio</h2>
        <p>TERVI es una herramienta de apoyo tecnológico para la rehabilitación física. La información, ejercicios y videos proporcionados son de carácter educativo y complementario. No sustituyen el diagnóstico presencial de un profesional de la salud colegiado.</p>

        <h2>2. Uso de Datos Personales</h2>
        <p>En cumplimiento con las normativas de protección de datos, TERVI recopila información como peso, altura y edad con el único fin de personalizar su experiencia y evolución clínica. Sus datos están encriptados y solo son accesibles por usted y el personal médico autorizado.</p>

        <h2>3. Responsabilidad del Usuario</h2>
        <p>El usuario se compromete a:</p>
        <ul>
            <li>Proporcionar información veraz sobre su estado físico.</li>
            <li>Realizar los ejercicios bajo su propia responsabilidad y supervisión si es necesario.</li>
            <li>No compartir sus credenciales de acceso con terceros.</li>
        </ul>

        <h2>4. Propiedad Intelectual</h2>
        <p>Todo el contenido visual, videos y algoritmos de seguimiento son propiedad exclusiva de TERVI. Queda prohibida su reproducción parcial o total sin autorización previa por escrito.</p>

        <h2>5. Limitación de Responsabilidad</h2>
        <p>TERVI no se hace responsable por lesiones derivadas de una mala ejecución de los ejercicios o por la omisión de recomendaciones médicas externas.</p>

        <div style="text-align: center; margin-top: 40px;">
            <p>Al hacer uso de la plataforma, usted confirma que ha leído y aceptado estos términos.</p>
            <a href="index.php" class="btn-regresar">Entendido y Aceptar</a>
        </div>
    </div>

    <div class="footer-legal">
        &copy; <?= date('Y') ?> TERVI - Innovación en Salud Digital. Todos los derechos reservados.
    </div>
</div>

<?php include 'includes/footer.php'; ?>