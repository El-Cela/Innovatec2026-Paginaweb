<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - TERVI</title>
    <link rel="stylesheet" href="assets/css/estilos.css"> <style>
        .reg-container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .full-width { grid-column: span 2; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px; }
        button { width: 100%; padding: 12px; background: #2e86c1; color: white; border: none; border-radius: 8px; margin-top: 20px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="reg-container">
        <h2>💙 Crea tu cuenta TERVI</h2>
        <form action="procesos/procesar_registro.php" method="POST">
            <div class="form-grid">
                <div class="full-width">
                    <label>Nombre</label>
                    <input type="text" name="nombre_usu" required>
                </div>
                <div>
                    <label>Apellido Paterno</label>
                    <input type="text" name="apellidoP_usu" required>
                </div>
                <div>
                    <label>Apellido Materno</label>
                    <input type="text" name="apellidoM_usu" required>
                </div>
                <div class="full-width">
                    <label>Correo Electrónico</label>
                    <input type="email_usu" name="correo_usu" required>
                </div>
                <div class="full-width">
                    <label>Contraseña</label>
                    <input type="password" name="contraseña_usu" required>
                </div>
                <div>
                    <label>Edad</label>
                    <input type="number" name="edad_usu" required>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo_usu">
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label>Peso (kg)</label>
                    <input type="number" step="0.1" name="peso_usu" required>
                </div>
                <div>
                    <label>Altura (cm)</label>
                    <input type="number" name="altura_usu" required>
                </div>
            </div>
            <div style="margin: 15px 0; text-align: left; font-size: 14px;">
    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
        <input type="checkbox" name="acepto_terminos" required style="width: auto; margin: 0;">
        <span>He leído y acepto los <a href="terminos.php" target="_blank" style="color: #2e86c1; font-weight: bold; text-decoration: none;">Términos y Condiciones</a></span>
    </label>
</div>
            <button type="submit" name="registrar">Finalizar Registro</button>
        </form>
        <p style="text-align: center; margin-top: 15px;">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>