<?php
// Configuración de la base de datos
$servidor = "localhost";
$usuario  = "root";     // Usuario por defecto en XAMPP
$password = "";         // Contraseña vacía por defecto en XAMPP
$base_datos = "rv_rehabilitacion"; // ASEGÚRATE DE QUE ESTE SEA EL NOMBRE DE TU BD

// Crear la conexión
$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

// Verificar si la conexión falló
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar el juego de caracteres a UTF-8 (para que se vean los acentos y la ñ)
mysqli_set_charset($conexion, "utf8");
?>