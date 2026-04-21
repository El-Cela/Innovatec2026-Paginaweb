<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
?>

<style>
    .legal-container {
        max-width: 900px;
        margin: 120px auto 50px;
        padding: 0 20px;
        font-family: 'Segoe UI', sans-serif;
    }

    .legal-card {
        background: white;
        padding: 50px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 8px solid #27ae60; /* Color verde para transmitir confianza/seguridad */
        line-height: 1.7;
        color: #333;
    }

    .legal-card h1 {
        color: #27ae60;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .legal-card h2 {
        color: #2c3e50;
        font-size: 1.2rem;
        margin-top: 25px;
        border-left: 4px solid #27ae60;
        padding-left: 10px;
    }

    .legal-card p {
        margin-bottom: 15px;
        text-align: justify;
    }

    .highlight {
        color: #27ae60;
        font-weight: bold;
    }

    .btn-regresar {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 25px;
        background: #27ae60;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }
</style>

<div class="legal-container">
    <div class="legal-card">
        <h1>Aviso de Privacidad</h1>
        <p><strong>TERVI</strong>, con domicilio en México, es responsable del tratamiento de sus datos personales. Su privacidad y la seguridad de su información clínica son nuestra máxima prioridad.</p>

        <h2>1. Datos Personales que Recabamos</h2>
        <p>Para brindar el servicio de rehabilitación virtual, recolectamos:</p>
        <ul>
            <li><strong>Datos de Identificación:</strong> Nombre completo, correo electrónico.</li>
            <li><strong>Datos Biométricos y de Salud:</strong> Edad, peso, estatura, índice de masa corporal (IMC) e historial de ejercicios realizados.</li>
        </ul>

        <h2>2. Finalidad del Tratamiento</h2>
        <p>Sus datos son utilizados exclusivamente para:</p>
        <ul>
            <li>Personalizar las rutinas de rehabilitación física.</li>
            <li>Generar el historial clínico digital y las recetas médicas.</li>
            <li>Permitir el seguimiento del progreso por parte del personal especializado (Administrador/Doctor).</li>
            <li>Enviar notificaciones sobre nuevas indicaciones en su recetario.</li>
        </ul>

        <h2>3. Protección de Datos Sensibles</h2>
        <p>Le informamos que sus datos de salud son considerados <span class="highlight">Datos Sensibles</span>. TERVI implementa medidas de seguridad técnicas y administrativas para evitar su robo, pérdida o acceso no autorizado.</p>

        <h2>4. Derechos ARCO</h2>
        <p>Usted tiene derecho a conocer qué datos tenemos de usted (Acceso), corregirlos (Rectificación), solicitar que los eliminemos (Cancelación) u oponerse al uso de los mismos (Oposición). Para ejercer estos derechos, puede contactar al administrador del sistema.</p>

        <h2>5. Transferencia de Datos</h2>
        <p>TERVI <span class="highlight">no vende ni transfiere</span> sus datos personales a empresas externas ni terceros con fines comerciales.</p>

        <div style="text-align: center;">
            <a href="index.php" class="btn-regresar">He leído el aviso</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>