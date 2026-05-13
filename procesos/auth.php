<?php
session_start();
include '../config/conexion.php'; 
mysqli_set_charset($conexion, "utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = mysqli_real_escape_string($conexion, trim($_POST['user']));
    $pass = trim($_POST['pass']);

    // 1. Buscamos en usuarios (Pacientes)
    $sql_usu = "SELECT * FROM usuarios WHERE correo_usu = '$user'";
    $res_usu = mysqli_query($conexion, $sql_usu);

    if ($res_usu && mysqli_num_rows($res_usu) > 0) {
        $datos = mysqli_fetch_assoc($res_usu);
        // Verificamos si la clave coincide (texto plano o hash)
        if ($pass === $datos['contraseña_usu'] || password_verify($pass, $datos['contraseña_usu'])) {
            $_SESSION['user_auth'] = true;
            $_SESSION['id_usuario'] = $datos['id_usuario']; // IMPORTANTE PARA EL HISTORIAL
            $_SESSION['nombre_usu'] = $datos['nombre_usu'];
            $_SESSION['rol'] = 'paciente';
            header("Location: ../index.php");
            exit();
        }
    }

    // 2. Buscamos en administrador (Médicos)
    $sql_adm = "SELECT * FROM administrador WHERE usuario_adm = '$user'";
    $res_adm = mysqli_query($conexion, $sql_adm);

    if ($res_adm && mysqli_num_rows($res_adm) > 0) {
        $datos = mysqli_fetch_assoc($res_adm);
        if ($pass === $datos['contraseña_adm'] || password_verify($pass, $datos['contraseña_adm'])) {
            $_SESSION['admin_auth'] = true;
            $_SESSION['id_admin'] = $datos['id_administrador'];
            $_SESSION['nombre_usu'] = $datos['nombre_adm'];
            $_SESSION['rol'] = 'admin';
            header("Location: ../admin.php");
            exit();
        }
    }

    header("Location: ../login.php?error=credenciales");
    exit();
}