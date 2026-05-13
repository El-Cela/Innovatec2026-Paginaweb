<div style="background: #f4f7f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, sans-serif; padding: 20px;">
    
    <div style="width: 100%; max-width: 1000px; display: flex; background: #fff; border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); overflow: hidden;">
        
        <div style="flex: 1; background: linear-gradient(135deg, #0056b3 0%, #003d7a 100%); padding: 40px; display: flex; flex-direction: column; justify-content: center; color: white;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin: 0;">TERVI</h1>
            <p style="color: #ffd700; letter-spacing: 2px; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;">Historial Clínico Digital</p>
            
            <div style="margin-top: 30px;">
                <p style="font-size: 1rem; line-height: 1.6; opacity: 0.9;">
                    "Al completar tu perfil clínico, nuestro sistema de IA ajusta los ejercicios de RV a tus capacidades físicas específicas."
                </p>
            </div>

            <div style="margin-top: 40px; font-size: 0.85rem; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
                <i class="fas fa-lock"></i> Tus datos están protegidos por la Ley de Protección de Datos Personales.
            </div>
        </div>

        <div style="flex: 1.8; padding: 40px 50px;">
            <h2 style="color: #0056b3; margin-bottom: 5px; font-size: 1.6rem;">Crea tu cuenta</h2>
            <p style="color: #7f8c8d; margin-bottom: 30px; font-size: 0.9rem;">Información necesaria para tu protocolo de rehabilitación.</p>

            <form action="procesos/procesar_registro.php" method="POST" class="form-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 15px;">
                
                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">NOMBRE(S)</label>
                    <input type="text" name="nombre_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">APELLIDO PATERNO</label>
                    <input type="text" name="apellidoP_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">APELLIDO MATERNO</label>
                    <input type="text" name="apellidoM_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>

                <div style="grid-column: span 3;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">CORREO ELECTRÓNICO</label>
                    <input type="email" name="correo_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>
                <div style="grid-column: span 3;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">CONTRASEÑA</label>
                    <input type="password" name="contrasena_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>

                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">EDAD</label>
                    <input type="number" name="edad_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">PESO (KG)</label>
                    <input type="number" step="0.1" name="peso_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">ALTURA (CM)</label>
                    <input type="number" name="altura_usu" required style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                </div>

                <div style="grid-column: span 6;">
                    <label style="font-weight: bold; font-size: 0.75rem; color: #34495e;">SEXO</label>
                    <select name="sexo_usu" style="width: 100%; padding: 10px; border: 2px solid #e1e8ed; border-radius: 8px;">
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div style="grid-column: span 6; margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; cursor: pointer;">
                        <input type="checkbox" name="acepto_terminos" required style="width: auto;">
                        <span>Acepto los <a href="#" style="color: #0056b3; font-weight: bold; text-decoration: none;">Términos y Condiciones</a> de salud.</span>
                    </label>
                </div>

                <div style="grid-column: span 6; margin-top: 20px;">
                    <button type="submit" name="registrar" style="width: 100%; padding: 15px; background: #0056b3; color: white; border: none; border-radius: 10px; font-weight: 800; cursor: pointer; transition: 0.3s; font-size: 1rem;">
                        FINALIZAR REGISTRO
                    </button>
                    <p style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: #7f8c8d;">
                        ¿Ya tienes cuenta? <a href="login.php" style="color: #0056b3; font-weight: bold; text-decoration: none;">Inicia sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>