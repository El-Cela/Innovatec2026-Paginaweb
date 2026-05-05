<?php
function es_usuario_pro($conexion, $id_usuario) {
    // Buscamos si existe un pago completado para este usuario
    $query = "SELECT id_venta FROM ventas WHERE id_usuario = '$id_usuario' AND estado_pago = 'Completado'";
    $resultado = mysqli_query($conexion, $query);
    return (mysqli_num_rows($resultado) > 0);
}
?>