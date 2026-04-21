<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TERVI</title>
    <style>
        body { font-family: sans-serif; background: #f4f9ff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 320px; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #d6eaf8; border-radius: 10px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2e86c1; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>💙 Bienvenido</h2>
        <form action="procesos/procesar_login.php" method="POST">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit" name="entrar">Ingresar</button>
        </form>
        <p>¿No eres miembro? <a href="registro.php">Regístrate</a></p>
    </div>
</body>
</html>