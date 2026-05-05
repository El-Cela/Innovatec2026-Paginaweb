<?php
include 'includes/header.php';
// Proteccion de la pagina: si no está logueado, mandamos al login
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?msg=debes_iniciar_sesion");
    exit();
}
?>

<div class="container" style="margin-top: 120px; margin-bottom: 50px;">
    <!-- Encabezado del Proyecto basado en Innovatec -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #2e86c1; margin-bottom: 5px;">TERVI</h1>
        <p style="text-transform: uppercase; letter-spacing: 1px; color: #555; font-size: 0.9rem;">
            Terapia de Ejercicio en Realidad Virtual Interactiva
        </p>
        <span style="background: #e8f4fd; color: #2e86c1; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">
            Categoría: Tecnologías para la Salud Humana
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
        
        <!-- Formulario de Pago -->
        <div class="card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h2 style="color: #2e86c1; margin-bottom: 20px;">💳 Detalles de Pago</h2>
            
            <form action="procesos/procesar_compra.php" method="POST" id="form-pago">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:bold;">Nombre en la tarjeta</label>
                    <input type="text" name="nombre_tarjeta" placeholder="Como aparece en la tarjeta" required 
                           style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:bold;">Número de Tarjeta</label>
                    <input type="text" name="num_tarjeta" placeholder="0000 0000 0000 0000" maxlength="16" required
                           style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; font-weight:bold;">Expira (MM/AA)</label>
                        <input type="text" name="expira" placeholder="MM/AA" maxlength="5" required
                               style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    </div>
                    <div>
                        <label style="display:block; font-weight:bold;">CVC</label>
                        <input type="password" name="cvc" placeholder="123" maxlength="3" required
                               style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    </div>
                </div>

                <button type="submit" style="width:100%; padding:15px; background:#D4AF37; color:black; border:none; border-radius:30px; font-weight:bold; margin-top:30px; cursor:pointer;">
                    ADQUIRIR LICENCIA SAAS 💎
                </button>
            </form>
        </div>

        <!-- Resumen basado en Plan de Negocios -->
        <div class="card" style="background: #f8fbff; padding: 25px; border-radius: 15px; border: 1px solid #d6eaf8;">
            <h3 style="margin-top:0;">Resumen de suscripción</h3>
            <p style="font-size: 0.85rem; color: #666;">Modelo: SaaS (Software as a Service)</p>
            <hr>
            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                <span>Licencia TERVI (Mensual)</span>
                <strong>$369.00</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                <span>Acceso a Entornos Unity</span>
                <span style="color: green;">Incluido</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                <span>Reportes Biomecánicos</span>
                <span style="color: green;">Incluido</span>
            </div>
            <hr>
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                <span>Total:</span>
                <span style="color: #2e86c1;">$369.00 MXN</span>
            </div>
            
            <div style="background: #fff; padding: 10px; border-radius: 8px; margin-top: 20px; border: 1px dashed #ccc;">
                <p style="font-size: 0.75rem; color: #555; margin: 0;">
                    🛡️ <strong>Garantía de Propiedad:</strong> Software protegido ante INDAUTOR e IMPI. Medicina de precisión con sensores 6DoF.
                </p>
            </div>
            
            <p style="font-size: 0.7rem; color: #777; margin-top: 15px; text-align: center;">
                🔒 Pago seguro encriptado.
            </p>
        </div>

    </div>
    
</div>

<?php include 'includes/footer.php'; ?>