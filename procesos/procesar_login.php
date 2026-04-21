<?php
session_start();
include '../config/conexion.php';

if (isset($_POST['entrar'])) {
    // 1. Limpiamos los datos recibidos
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $password = $_POST['pass']; // Contraseña tal cual la escribió el usuario

    // 2. Buscamos al usuario en la tabla (asumiendo que tu columna se llama 'correo')
    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $query);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        
        // 3. Verificamos la contraseña usando el hash que guardamos en el registro
        if (password_verify($password, $usuario['password'])) {
            
            // ¡ÉXITO! Creamos la sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // 4. Redireccionamos a la página principal
            header("Location: ../index.php");
            exit();

        } else {
            // Contraseña incorrecta
            header("Location: ../login.php?error=pass_incorrecta");
            exit();
        }
    } else {
        // Correo no encontrado
        header("Location: ../login.php?error=usuario_no_existe");
        exit();
    }
} else {
    // Si intentan entrar al archivo sin usar el formulario
    header("Location: ../login.php");
    exit();
}