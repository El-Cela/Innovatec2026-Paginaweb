<?php
include 'includes/header.php';
// Proteccion de la pagina: si no está logueado, mandamos al login
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php?msg=debes_iniciar_sesion");
    exit();
}
?>

<div class="container" style="margin-top: 120px; margin-bottom: 50px;">
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
        
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
                    CONFIRMAR Y PAGAR AHORA 💎
                </button>
            </form>
        </div>

        <div class="card" style="background: #f8fbff; padding: 25px; border-radius: 15px; border: 1px solid #d6eaf8;">
            <h3 style="margin-top:0;">Resumen de Compra</h3>
            <hr>
            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                <span>Licencia TERVI Pro</span>
                <strong>$499.00</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                <span>Soporte 24/7</span>
                <span style="color: green;">Gratis</span>
            </div>
            <hr>
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                <span>Total:</span>
                <span style="color: #2e86c1;">$499.00 MXN</span>
            </div>
            <p style="font-size: 0.8rem; color: #777; margin-top: 20px;">
                🔒 Pago seguro encriptado. Al comprar, aceptas nuestros términos de licencia.
            </p>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>