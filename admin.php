<?php 
session_start(); // Paso 1: Iniciar el motor de sesiones
$conexion = mysqli_connect("localhost", "root", "", "rv_rehabilitacion2");

if (!isset($_SESSION['admin_auth']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
// --- LÓGICA DE LOGIN ---
if (isset($_POST['login'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['user']);
    $password = $_POST['pass']; // Para el proyecto escolar, comparación directa

    if (($usuario == 'Mercedes' && $password == '12345') ||
        ($usuario == 'Cela' && $password == '1224') ||
        ($usuario == 'Eduardo' && $password == 'admin123')){
        $_SESSION['admin_auth'] = true;
        $_SESSION['admin_user'] = $usuario;
    } else {
        $error_login = "Usuario o contraseña incorrectos";
    }
}

// --- LÓGICA DE CERRAR SESIÓN ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// --- LÓGICA DE HISTORIAL Y RECETAS (Actualizada) ---
if (isset($_POST['guardar_receta'])) {
    $id_pac = intval($_POST['id_paciente']);
    $ind = mysqli_real_escape_string($conexion, $_POST['indicaciones']);
    // Tabla: recetario | Columna: indicacion
    mysqli_query($conexion, "INSERT INTO recetario (id_usuario, indicacion) VALUES ($id_pac, '$ind')");
    header("Location: admin.php?sec=gestionar&id=$id_pac&res=ok");
}

if (isset($_POST['guardar_nota'])) {
    $id_pac = intval($_POST['id_paciente']);
    $nota = mysqli_real_escape_string($conexion, $_POST['nota']);
    // Tabla: historial_clinico | Columna: nota_evolucion
    mysqli_query($conexion, "INSERT INTO historial_clinico (id_usuario, nota_evolucion) VALUES ($id_pac, '$nota')");
    header("Location: admin.php?sec=gestionar&id=$id_pac&res=ok");
}

if (isset($_POST['actualizar_receta'])) {
    $id_receta = intval($_POST['id_receta']);
    $id_pac = intval($_POST['id_paciente']);
    $nueva_ind = mysqli_real_escape_string($conexion, $_POST['indicaciones']);
    
    mysqli_query($conexion, "UPDATE recetario SET indicacion = '$nueva_ind' WHERE id_receta = $id_receta");
    header("Location: admin.php?sec=gestionar&id=$id_pac&res=editado");
}

if (isset($_POST['guardar_receta_completa'])) {
    $id_p = intval($_POST['id_paciente']);
    $fecha = $_POST['fecha_custom'];
    $doc = mysqli_real_escape_string($conexion, $_POST['medico']);
    $ind = mysqli_real_escape_string($conexion, $_POST['indicaciones']);
    
    $sql = "INSERT INTO recetario (id_usuario, indicacion, nombre_doctor, fecha) 
            VALUES ($id_p, '$ind', '$doc', '$fecha')";
    
    mysqli_query($conexion, $sql);
    header("Location: admin.php?sec=gestionar&id=$id_p&res=ok");
}
if (isset($_POST['actualizar_biometria'])) {
    $id_p = intval($_POST['id_paciente']);
    $ed = intval($_POST['n_edad']);
    $pe = floatval($_POST['n_peso']);
    $al = intval($_POST['n_altura']);
    $est = mysqli_real_escape_string($conexion, $_POST['n_estado']); // El nuevo estado

    // Actualizamos todo, incluyendo el estado de salud
    $sql = "UPDATE usuarios SET edad=$ed, peso=$pe, altura=$al, estado_salud='$est' WHERE id_usuario=$id_p";
    mysqli_query($conexion, $sql);
    
    header("Location: admin.php?sec=gestionar&id=$id_p&res=ok");
}

// ... después de tu lógica de login ...

if (isset($_SESSION['admin_auth'])) {
    // Si el administrador está logueado, mostramos el panel
    $seccion = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
    if ($seccion == 'editar_video') {
        // Al incluirlo aquí, hereda la $conexion que hiciste arriba
        include 'procesos/procesar_edicion_video.php'; 
    } else {
        // Mostrar tabla de videos u otras secciones
    }
} else {
    // Mostrar formulario de login
}

// --- PROTECCIÓN DE LA PÁGINA ---
// Si NO existe la sesión, mostramos el formulario de entrada
if (!isset($_SESSION['admin_auth'])): 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - MinndTeen Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f7ff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 350px; text-align: center; }
        h2 { color: #2e86c1; margin-bottom: 25px; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #d6eaf8; border-radius: 10px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #2e86c1; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 16px; }
        button:hover { background: #21618c; }
        .error { color: #e74c3c; font-size: 14px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>💙 Admin Login</h2>
        <?php if(isset($error_login)) echo "<p class='error'>$error_login</p>"; ?>
        <form method="POST">
            <input type="text" name="user" placeholder="Usuario administrador" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit" name="login">Entrar al Panel</button>
        </form>
        <p style="margin-top: 20px;"><a href="index.php" style="color: #95a5a6; text-decoration: none; font-size: 13px;">← Volver al sitio</a></p>
    </div>
</body>
</html>

<?php 
exit(); // Detenemos la carga del resto de la página si no está logueado
endif; 
?>

<?php 
// --- LÓGICA DE ELIMINACIÓN Y ACCIONES ---
if (isset($_GET['borrar_video'])) {
    $id = intval($_GET['borrar_video']);
    mysqli_query($conexion, "DELETE FROM videos WHERE id_video = $id");
    header("Location: admin.php?sec=videos");
}

if (isset($_GET['del_ejercicio'])) {
    $id_a_borrar = intval($_GET['del_ejercicio']); 
    
    if($id_a_borrar > 0) {
        // EL WHERE ES VITAL. Sin esto, borras todo.
        $sql_borrar = "DELETE FROM series_ejercicio WHERE id_ejercicio = $id_a_borrar";
        mysqli_query($conexion, $sql_borrar);
        header("Location: admin.php?sec=ejercicio&status=deleted");
        exit();
    }
}

if (isset($_GET['del_contenido'])) {
    $id = intval($_GET['del_contenido']);
    mysqli_query($conexion, "DELETE FROM contenidos WHERE id_contenido = $id");
    header("Location: admin.php?sec=conceptos");
}

if (isset($_GET['aprobar_comentario'])) {
    $id_c = intval($_GET['aprobar_comentario']);
    mysqli_query($conexion, "UPDATE comentarios SET estado = 'aprobado' WHERE id_comentario = $id_c");
    header("Location: admin.php?sec=comentarios&status=approved");
    exit();
}

if (isset($_GET['borrar_comentario'])) {
    $id_b = intval($_GET['borrar_comentario']);
    mysqli_query($conexion, "DELETE FROM comentarios WHERE id_comentario = $id_b");
    header("Location: admin.php?sec=comentarios&status=deleted");
    exit();
}

$seccion = isset($_GET['sec']) ? $_GET['sec'] : 'videos';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">💙 TERVI Admin</div>
        <ul class="nav-links" style="height: calc(100% - 100px); display: flex; flex-direction: column;">
    <li><a href="admin.php?sec=videos" class="<?= $seccion == 'videos' ? 'active' : '' ?>">🎥 Gestión de Videos</a></li>
    <li><a href="admin.php?sec=conceptos" class="<?= $seccion == 'conceptos' ? 'active' : '' ?>">🧠 Diccionario / Temas</a></li>
    <li><a href="admin.php?sec=comentarios" class="<?= $seccion == 'comentarios' ? 'active' : '' ?>">💬 Comentarios</a></li>
    <li><a href="admin.php?sec=ejercicio" class="<?= $seccion == 'ejercicio' ? 'active' : '' ?>">🏋️ Ejercicios</a></li>
    <li><a href="admin.php?sec=pacientes" class="<?= $seccion == 'pacientes' ? 'active' : '' ?>">📋 Expedientes Pacientes</a></li>
    <li><a href="admin.php?sec=inicio" class="<?= $seccion == 'inicio' ? 'active' : '' ?>">🏠 Inicio</a></li>

    <div style="flex-grow: 1;"></div>
    <li style="border-top: 1px solid #eee;">
        <a href="admin.php?logout=true" style="color: #e74c3c; font-weight: bold; background: #fff5f5;" 
           onclick="return confirm('¿Estás segura de que quieres cerrar sesión, Mercedes?')">
            🚪 Cerrar Sesión
        </a>
    </li>
    <li>
        <a href="index.php" style="color: #95a5a6; font-size: 13px;">🏠 Volver al Sitio Público</a>
    </li>
        </ul>
    </div>

   <div class="main-content">
    <?php if($seccion == 'videos'): ?>
        <h1>Control de Videos</h1>
        
        <div class="card">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Duración</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $vids = mysqli_query($conexion, "SELECT v.*, c.nombre as cat_nombre FROM videos v JOIN categorias c ON v.id_categoria = c.id_categoria");
                        while($v = mysqli_fetch_assoc($vids)) {
                            echo "<tr>
                                <td>{$v['titulo_video']}</td>
                                <td>{$v['cat_nombre']}</td>
                                <td>{$v['duracion_minutos']} min</td>
                                <td>
                                    <a href='admin.php?sec=editar_video&id={$v['id_video']}' class='btn-edit' style='text-decoration:none; margin-right:10px;'>✏️ Editar</a>
                                    <a href='admin.php?borrar_video={$v['id_video']}' class='btn btn-delete' onclick='return confirm(\"¿Estás seguro?\")' style='color:red;'>🗑️ Borrar</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" id="form-video">
            <h3>Añadir Nuevo Video</h3>
            <form action="procesos/procesar_admin.php" method="POST">
                <div class="form-group"><label>Título</label><input type="text" name="titulo" required></div>
                <div class="form-group"><label>URL YouTube</label><input type="text" name="url" required></div>
                <div class="form-group"><label>Tiempo</label><input type="text" name="duracion" required></div>
                <div class="form-group">
                    <label>Categoría</label>
                    <select name="id_categoria">
                        <?php
                        $cats = mysqli_query($conexion, "SELECT * FROM categorias");
                        while($c = mysqli_fetch_assoc($cats)) { echo "<option value='{$c['id_categoria']}'>{$c['nombre']}</option>"; }
                        ?>
                    </select>
                </div>
                <button type="submit" name="nuevo_video" class="btn btn-add" style="width:100%">Guardar Video</button>
            </form>
        </div>

    <?php elseif($seccion == 'editar_video'): ?>
        <?php
            // 1. Buscamos los datos del video que queremos editar
            $id_edit = intval($_GET['id']);
            $res = mysqli_query($conexion, "SELECT * FROM videos WHERE id_video = $id_edit");
            $ve = mysqli_fetch_assoc($res);
        ?>
        
        <h1>Editar Video</h1>
        <div class="card">
            <form action="procesos/procesar_edicion_video.php" method="POST">
                <input type="hidden" name="id_video" value="<?= $ve['id_video'] ?>">

                <div class="form-group">
                    <label>Título del Video</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($ve['titulo_video']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>URL YouTube</label>
                    <input type="text" name="url" value="<?= htmlspecialchars($ve['url_youtube']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Tiempo (minutos)</label>
                    <input type="text" name="duracion" value="<?= $ve['duracion_minutos'] ?>" required>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="actualizar_video" class="btn btn-add" style="flex: 1;">Actualizar Cambios</button>
                    <a href="admin.php?sec=videos" class="btn" style="flex: 1; background: #95a5a6; color: white; text-align: center; text-decoration: none; padding: 10px; border-radius: 5px;">Cancelar</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

        <?php if($seccion == 'conceptos'): ?>
            <h1>Gestión de Conceptos y Guías</h1>
            <div class="card">
                <p style="color: #7f8c8d;">Controla las tarjetas y bloques informativos de conceptos.php</p>
                <a href="formulario_contenido.php" class="btn btn-add">+ Nuevo Concepto / Información</a>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Slug</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $res = mysqli_query($conexion, "SELECT * FROM contenidos ORDER BY tipo_contenido, titulo");
                            while($row = mysqli_fetch_assoc($res)): 
                                $color_tipo = ($row['tipo_contenido'] == 'Concepto') ? '#5dade2' : '#2e86c1';
                            ?>
                            <tr>
                                <td><strong><?= $row['titulo'] ?></strong></td>
                                <td><span style="background: <?= $color_tipo ?>; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;"><?= $row['tipo_contenido'] ?></span></td>
                                <td><small><?= $row['slug'] ?></small></td>
                                <td>
                                    <a href="formulario_contenido.php?edit=<?= $row['id_contenido'] ?>" class="btn btn-edit">Modificar</a>
                                    <a href="admin.php?sec=conceptos&del_contenido=<?= $row['id_contenido'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar?')">Borrar</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <?php if($seccion == 'comentarios'): ?>
            <h1>💬 Comentarios Pendientes</h1>
            <div class="card">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Comentario</th>
                                <th>Video</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $coms = mysqli_query($conexion, "SELECT c.*, v.titulo_video FROM comentarios c JOIN videos v ON c.id_video = v.id_video WHERE c.estado = 'pendiente'");
                            while($com = mysqli_fetch_assoc($coms)) {
                                echo "<tr>
                                    <td>{$com['comentario']}</td>
                                    <td>{$com['titulo_video']}</td>
                                    <td>
                                        <a href='admin.php?aprobar_comentario={$com['id_comentario']}' class='btn btn-approve'>Aprobar</a>
                                        <a href='admin.php?sec=comentarios&borrar_comentario={$com['id_comentario']}' class='btn btn-delete'>Eliminar</a>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

<?php if($seccion == 'ejercicio'): ?>
    <h1>🦾 Gimnasia Terapéutico</h1>
    
    <div class="card" id="form-section">
        <?php include 'formulario_ejercicio.php'; ?>
    </div>

    <div class="card">
        <h2>📋 Catálogo de Especialidades</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Ejercicio</th>
                        <th>Especialidad</th> <th>Dificultad</th>
                        <th>Esquema (S x R)</th>
                        <th>Frecuencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Unimos series_ejercicio con la tabla categoria para traer el nombre real
                    $sql = "SELECT e.*, c.nombre AS nombre_categoria 
                            FROM series_ejercicio e 
                            LEFT JOIN categorias c ON e.id_categoria = c.id_categoria 
                            ORDER BY c.nombre ASC, e.id_ejercicio DESC";
                    
                    $lista = mysqli_query($conexion, $sql);

                    // Verificación de seguridad para evitar el Fatal Error
                    if(!$lista) {
                        echo "<tr><td colspan='6' style='color:red;'>Error en la consulta: " . mysqli_error($conexion) . "</td></tr>";
                    } else if(mysqli_num_rows($lista) == 0) {
                        echo "<tr><td colspan='6' style='text-align:center;'>No hay ejercicios registrados aún.</td></tr>";
                    } else {
                        while($row = mysqli_fetch_assoc($lista)): 
                            // Semáforo de dificultad TERVI
                            $badge_color = "#27ae60"; // Bajo
                            if($row['nivel_dificultad'] == 'Medio') $badge_color = "#f39c12"; 
                            if($row['nivel_dificultad'] == 'Alto') $badge_color = "#e74c3c"; 
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['nombre']) ?></strong></td>
                            
                            <td>
                                <span style="color: #2e86c1; font-size: 12px; font-weight: bold; background: #eef7ff; padding: 3px 8px; border-radius: 5px;">
                                    <?= htmlspecialchars($row['nombre_categoria'] ?? 'Sin Categoría') ?>
                                </span>
                            </td>

                            <td>
                                <span style="background: <?= $badge_color ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: bold;">
                                    <?= htmlspecialchars($row['nivel_dificultad']) ?>
                                </span>
                            </td>
                            
                            <td><?= $row['series'] ?> sets x <?= $row['repeticiones'] ?> reps</td>
                            
                            <td><?= htmlspecialchars($row['frecuencia']) ?></td>
                            
                            <td>
                                <a href="admin.php?sec=ejercicio&edit=<?= $row['id_ejercicio'] ?>#form-section" class="btn btn-edit" title="Editar">✏️</a>
                                <a href="admin.php?del_ejercicio=<?= $row['id_ejercicio'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar este protocolo?')" title="Eliminar">🗑️</a>
                            </td>
                        </tr>
                        <?php 
                        endwhile; 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

        <style>
            /* Contenedor de Grid para formularios */
.gestion-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

/* Tarjetas mejoradas */
.card-med {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-top: 5px solid #2e86c1; /* Línea decorativa azul */
}

/* Inputs y Textareas estilo moderno */
.card-med input, .card-med textarea, .card-med select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #dcdde1;
    border-radius: 8px;
    box-sizing: border-box;
    font-family: inherit;
    transition: 0.3s;
}

.card-med input:focus, .card-med textarea:focus {
    border-color: #2e86c1;
    outline: none;
    box-shadow: 0 0 5px rgba(46, 134, 193, 0.2);
}

.card-med label {
    font-size: 13px;
    font-weight: 600;
    color: #487eb0;
}

/* Botones personalizados */
.btn-med {
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    color: white;
    transition: 0.3s;
    width: 100%;
}

.btn-blue { background: #2e86c1; }
.btn-blue:hover { background: #21618c; }
.btn-green { background: #27ae60; }
.btn-green:hover { background: #1e8449; }

/* Lista de notas */
.nota-item {
    border-left: 4px solid #27ae60;
    background: #f4fdf7;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 0 10px 10px 0;
    position: relative;
}

.nota-item small {
    color: #27ae60;
    font-weight: bold;
}

.nota-item p {
    font-size: 14px;
    color: #2f3640;
    margin: 5px 0;
}

/* Tabla de pacientes */
.table-pacientes {
    width: 100%;
    border-collapse: collapse;
}

.table-pacientes th {
    text-align: left;
    background: #f5f6fa;
    padding: 15px;
    color: #2e86c1;
}

.table-pacientes td {
    padding: 15px;
    border-bottom: 1px solid #f1f2f6;
}
        </style>
 <?php if($seccion == 'pacientes'): ?>
    <h1>Expedientes de Pacientes</h1>
    <div class="card">
        <div class="table-wrapper">
            <table class="table-pacientes">
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM usuarios ORDER BY nombre_usu ASC";
                    $pacs = mysqli_query($conexion, $query);
                    
                    if (!$pacs) {
                        die("<div class='error'>Error al cargar pacientes: " . mysqli_error($conexion) . "</div>");
                    }

                    if(mysqli_num_rows($pacs) == 0) {
                        echo "<tr><td colspan='3' style='text-align:center; padding:20px;'>No hay pacientes registrados aún.</td></tr>";
                    }

                    while($p = mysqli_fetch_assoc($pacs)):
                        // Lógica de semáforo de salud (Medicina de Precisión)
                        $color = "#27ae60"; // Verde (Excelente)
                        if(isset($p['estado_salud'])){
                            if($p['estado_salud'] == 'estable') $color = "#f1c40f"; // Amarillo
                            if($p['estado_salud'] == 'critico') $color = "#e74c3c"; // Rojo
                        }
                    ?>
                    <tr>
                        <td>
                            <span style="height:12px; width:12px; background:<?= $color ?>; border-radius:50%; display:inline-block; margin-right:8px; border: 1px solid rgba(0,0,0,0.1);"></span>
                            <strong><?= htmlspecialchars($p['nombre_usu']." ".$p['apellidoP_usu']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($p['correo_usu']) ?></td>
                        <td>
                            <a href="admin.php?sec=gestionar&id=<?= $p['id_usuario'] ?>" class="btn-med btn-blue" style="text-decoration:none; padding: 8px 15px;">📂 Abrir Expediente</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if($seccion == 'gestionar'): 
    $id_p = intval($_GET['id']);
    $res_p = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = $id_p");
    $pac = mysqli_fetch_assoc($res_p);
?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>👨‍⚕️ Expediente: <?= htmlspecialchars($pac['nombre_usu']." ".$pac['apellidoP_usu']) ?></h1>
        <a href="admin.php?sec=pacientes" class="btn" style="background:#95a5a6; color:white; text-decoration:none; padding:8px 15px; border-radius:8px;">← Volver</a>
    </div>

    <div class="card-med" style="margin-bottom: 20px; border-left: 5px solid #3498db;">
        <h3>📊 Datos Vitales (Actualizar)</h3>
        <form method="POST" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; align-items: end;">
            <input type="hidden" name="id_paciente" value="<?= $id_p ?>">
            <div>
                <label>Edad</label>
                <input type="number" name="n_edad" value="<?= $pac['edad_usu'] ?>">
            </div>
            <div>
                <label>Peso (kg)</label>
                <input type="number" step="0.1" name="n_peso" value="<?= $pac['peso_usu'] ?>">
            </div>
            <div>
                <label>Altura (cm)</label>
                <input type="number" name="n_altura" value="<?= $pac['altura_usu'] ?>">
            </div>
            <div class="form-group-medical">
    <label>Estado del Paciente</label>
    <select name="n_estado" style="width:100%; padding:8px; border-radius:8px;">
        <option value="excelente" <?= $pac['estado_salud'] == 'excelente' ? 'selected' : '' ?>>Verde - Excelente</option>
        <option value="estable" <?= $pac['estado_salud'] == 'estable' ? 'selected' : '' ?>>Amarillo - Estable</option>
        <option value="critico" <?= $pac['estado_salud'] == 'critico' ? 'selected' : '' ?>>Rojo - Urgente</option>
    </select>
</div>
            <button type="submit" name="actualizar_biometria" class="btn-med btn-blue">Actualizar Datos</button>
        </form>
    </div>

    <div class="gestion-container">
        
        <div class="card-med">
            <h3>💊 Emitir Nueva Receta</h3>
            <form method="POST">
                <input type="hidden" name="id_paciente" value="<?= $id_p ?>">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                    <div>
                        <label>Fecha de Emisión</label>
                        <input type="date" name="fecha_custom" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div>
                        <label>Nombre del Médico</label>
                        <input type="text" name="medico" placeholder="Nombre completo" required>
                    </div>
                </div>
                <label>Indicación / Medicamento</label>
                <textarea name="indicaciones" placeholder="Escribe aquí las instrucciones..." required style="height: 80px;"></textarea>
                <button type="submit" name="guardar_receta_completa" class="btn-med btn-blue" style="margin-top: 15px;">+ Generar Receta Oficial</button>
            </form>
        </div>

        <div class="card-med" style="border-top-color: #27ae60;">
            <h3>🩺 Evolución del Historial</h3>
            <form method="POST">
                <input type="hidden" name="id_paciente" value="<?= $id_p ?>">
                <textarea name="nota" placeholder="¿Cómo va el paciente?" required style="height: 100px;"></textarea>
                <button type="submit" name="guardar_nota" class="btn-med btn-green" style="margin-top: 15px;">Guardar Nota Médica</button>
            </form>

            <h4 style="margin-top: 25px; color: #27ae60;">Historial Reciente</h4>
            <div style="max-height: 250px; overflow-y: auto; margin-top: 10px;">
                <?php
                $notas = mysqli_query($conexion, "SELECT * FROM historial_clinico WHERE id_usuario = $id_p ORDER BY fecha DESC");
                while($n = mysqli_fetch_assoc($notas)): ?>
                    <div class="nota-item">
                        <small><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($n['fecha'])) ?></small>
                        <p><?= nl2br(htmlspecialchars($n['nota_evolucion'])) ?></p>
                        <a href="admin.php?sec=gestionar&id=<?= $id_p ?>&del_nota=<?= $n['id_historial'] ?>" style="color:#e74c3c; font-size:11px; text-decoration:none;" onclick="return confirm('¿Borrar?')">Eliminar</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
<?php endif; ?>

<?php if($seccion == 'inicio'): 
    // Consultas rápidas
    $count_p = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM usuarios"));
    $count_r = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM recetario WHERE DATE(fecha) = CURDATE()"));
?>
    <h1>Panel General de TERVI</h1>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div class="card-med" style="text-align: center; border-top: 5px solid #3498db;">
            <i class="fas fa-users" style="font-size: 2rem; color: #3498db;"></i>
            <h2><?= $count_p['total'] ?></h2>
            <p>Pacientes Totales</p>
        </div>
        <div class="card-med" style="text-align: center; border-top: 5px solid #e67e22;">
            <i class="fas fa-file-prescription" style="font-size: 2rem; color: #e67e22;"></i>
            <h2><?= $count_r['total'] ?></h2>
            <p>Recetas Hoy</p>
        </div>
        <div class="card-med" style="text-align: center; border-top: 5px solid #27ae60;">
            <i class="fas fa-check-circle" style="font-size: 2rem; color: #27ae60;"></i>
            <p>Sistema Operativo</p>
            <small>Base de datos: Conectada</small>
        </div>
    </div>
<?php endif; ?>
    </div>
</body>
</html>