<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
// LÍNEA VITAL:
mysqli_set_charset($conexion, "utf8mb4");

if (isset($_POST['entrar'])) {
    // Usamos trim para evitar espacios accidentales en el correo
    $correo = mysqli_real_escape_string($conexion, trim($_POST['correo_usu']));
    $password = $_POST['contraseña_usu'];

    $query = "SELECT * FROM usuarios WHERE correo_usu = '$correo'";
    $resultado = mysqli_query($conexion, $query);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // password_verify ahora funcionará porque el registro ya guardará hashes
        if (password_verify($password, $usuario['contraseña_usu'])) {
            
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_usu'] = $usuario['nombre_usu'];
            // Si no tienes la columna rol aún, esto evita errores:
            $_SESSION['rol'] = isset($usuario['rol']) ? $usuario['rol'] : 'paciente';

            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?error=pass_incorrecta");
            exit();
        }
    } else {
        header("Location: ../login.php?error=usuario_no_existe");
        exit();
    }
}