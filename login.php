<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TERVI</title>
    <style>
        :root {
            --primary: #0056b3;
            --secondary: #ffd700;
            --bg: #f4f7f9;
            --pastel-purple: #e0d4f7;
        }

        body {
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 550px;
        }

        /* Lado Izquierdo (Visual) */
        .side-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #003d7a 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }

        /* Lado Derecho (Formulario) */
        .form-panel {
            flex: 1.2;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tabs {
            display: flex;
            background: #f0f4f8;
            padding: 5px;
            border-radius: 50px;
            margin-bottom: 35px;
            gap: 5px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 50px;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .active { background: var(--primary) !important; color: white !important; }
        .inactive { background: transparent; color: #7f8c8d; }

        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            margin-bottom: 20px;
        }

        input:focus { border-color: var(--primary); }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 86, 179, 0.2);
        }

        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.8rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="side-panel">
        <h1 style="font-size: 3rem; margin: 0;">TERVI</h1>
        <p style="color: var(--secondary); font-weight: bold; letter-spacing: 2px;">REHABILITACIÓN INTELIGENTE</p>
        <p style="font-style: italic; opacity: 0.8; margin-top: 20px;">"Tecnología para tu evolución."</p>
    </div>

    <div class="form-panel">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary); margin: 0;">Bienvenido</h2>
            <p style="color: #7f8c8d;">Selecciona tu tipo de acceso</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="error-msg">Credenciales incorrectas. Verifica tus datos.</div>
        <?php endif; ?>

        <div class="tabs">
            <button id="btn-paciente" class="tab-btn active" onclick="setRole('paciente')">Paciente</button>
            <button id="btn-admin" class="tab-btn inactive" onclick="setRole('admin')">Administrador</button>
        </div>

        <form action="procesos/auth.php" method="POST">
            <input type="hidden" name="tipo_acceso" id="tipo_acceso" value="paciente">
            
            <label id="label-user" style="font-size: 0.75rem; font-weight: bold; color: #34495e;">CORREO ELECTRÓNICO</label>
            <input type="text" name="user" id="input-user" required placeholder="ejemplo@correo.com">

            <label style="font-size: 0.75rem; font-weight: bold; color: #34495e;">CONTRASEÑA</label>
            <input type="password" name="pass" required placeholder="••••••••">

            <button type="submit" class="btn-submit">INICIAR SESIÓN</button>
        </form>

        <div id="registro-seccion" style="text-align: center; margin-top: 20px;">
            <p style="font-size: 0.9rem; color: #7f8c8d;">¿Nuevo paciente? 
                <a href="registro.php" style="color: var(--primary); font-weight: bold; text-decoration: none;">Crear cuenta</a>
            </p>
        </div>
    </div>
</div>

<script>
function setRole(rol) {
    const tipoAcceso = document.getElementById('tipo_acceso');
    const btnP = document.getElementById('btn-paciente');
    const btnA = document.getElementById('btn-admin');
    const label = document.getElementById('label-user');
    const input = document.getElementById('input-user');
    const registro = document.getElementById('registro-seccion');

    if(rol === 'admin') {
        tipoAcceso.value = 'admin';
        btnA.className = 'tab-btn active';
        btnP.className = 'tab-btn inactive';
        label.innerText = 'USUARIO ADMINISTRADOR';
        input.placeholder = 'Ej: Dr_Armando';
        registro.style.display = 'none'; // Oculta registro para admin
    } else {
        tipoAcceso.value = 'paciente';
        btnP.className = 'tab-btn active';
        btnA.className = 'tab-btn inactive';
        label.innerText = 'CORREO ELECTRÓNICO';
        input.placeholder = 'ejemplo@correo.com';
        registro.style.display = 'block';
    }
}
</script>

</body>
</html>