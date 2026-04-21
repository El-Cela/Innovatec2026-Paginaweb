<?php
include '../config/conexion.php';
// Al principio de tu archivo de proceso:
if (!isset($_POST['acepto_terminos'])) {
    header("Location: ../registro.php?error=debes_aceptar_terminos");
    exit();
}
if (isset($_POST['registrar'])) {
    // 1. Capturamos y limpiamos los datos (Capa 8 segura 🛡️)
    $nombre    = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido_p = mysqli_real_escape_string($conexion, $_POST['apellido_paterno']);
    $apellido_m = mysqli_real_escape_string($conexion, $_POST['apellido_materno']);
    $correo    = mysqli_real_escape_string($conexion, $_POST['correo']);
    $password  = $_POST['pass']; // La encriptaremos abajo
    
    // Datos Médicos
    $edad      = intval($_POST['edad']);
    $sexo      = mysqli_real_escape_string($conexion, $_POST['sexo']);
    $peso      = floatval($_POST['peso']);
    $altura    = floatval($_POST['altura']);

    // 2. Encriptamos la contraseña (¡Seguridad primero!)
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    // 3. Verificamos si el correo ya existe para no duplicar
    $checar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");
    if (mysqli_num_rows($checar_correo) > 0) {
        header("Location: ../registro.php?error=correo_existe");
        exit();
    }

    // 4. Insertamos en la base de datos
    // Por defecto el rol es 'paciente'
    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, password, edad, genero, peso, altura, rol) 
            VALUES ('$nombre', '$apellido_p', '$apellido_m', '$correo', '$pass_hash', $edad, '$sexo', $peso, $altura, 'paciente')";

    if (mysqli_query($conexion, $sql)) {
        // Registro exitoso, mandamos al login para que entre
        header("Location: ../login.php?msg=registro_ok");
    } else {
        echo "Error en el registro: " . mysqli_error($conexion);
    }

} else {
    header("Location: ../registro.php");
}
?>