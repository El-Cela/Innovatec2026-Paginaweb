<?php
require_once __DIR__ . '/../config/conexion.php';
mysqli_set_charset($conexion, "utf8mb4");

if (!isset($_POST['acepto_terminos'])) {
    header("Location: ../registro.php?error=debes_aceptar_terminos");
    exit();
}
if (isset($_POST['registrar'])) {
    // 1. Capturamos y limpiamos los datos (Capa 8 segura 🛡️)
    $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre_usu']);
    $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellidoP_usu']);
    $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellidoM_usu']);
    $correo    = mysqli_real_escape_string($conexion, $_POST['correo_usu']);
    $password  = $_POST['contraseña_usu']; // La encriptaremos abajo
    
    // Datos Médicos
    $edad      = intval($_POST['edad_usu']);
    $sexo      = mysqli_real_escape_string($conexion, $_POST['sexo_usu']);
    $peso      = floatval($_POST['peso_usu']);
    $altura    = floatval($_POST['altura_usu']);

    // 2. Encriptamos la contraseña (¡Seguridad primero!)
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    // 3. Verificamos si el correo ya existe para no duplicar
    $checar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo_usu = '$correo'");
    if (mysqli_num_rows($checar_correo) > 0) {
        header("Location: ../registro.php?error=correo_existe");
        exit();
    }


// Forzamos que cualquier registro que venga de la web sea ROL PACIENTE
$query = "INSERT INTO usuarios (nombre_usu, apellidoP_usu, ..., rol) 
          VALUES ('$nombre', '$apellido_p', ..., 'paciente')";

// AGREGAMOS 'usuario_usu' al final de la lista de columnas y valores
$sql = "INSERT INTO usuarios (nombre_usu, apellidoP_usu, apellidoM_usu, correo_usu, contraseña_usu, edad_usu, sexo_usu, peso_usu, altura_usu, usuario_usu) 
        VALUES ('$nombre', '$apellido_p', '$apellido_m', '$correo', '$pass_hash', $edad, '$sexo', $peso, $altura, '$correo')";

if (mysqli_query($conexion, $sql)) {
    header("Location: ../login.php?msg=registro_ok");
    exit(); // Añade siempre exit después de un header
} else {
    // Si falla, esto te dirá por qué
    die("Error en la base de datos: " . mysqli_error($conexion));
}

} else {
    header("Location: ../registro.php");
}
?>