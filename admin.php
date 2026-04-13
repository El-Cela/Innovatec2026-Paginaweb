<?php 
session_start(); // Paso 1: Iniciar el motor de sesiones
$conexion = mysqli_connect("localhost", "root", "", "rv_rehabilitacion");

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

// --- LÓGICA DEL CHATBOT ---
// 1. Borrar una duda pendiente
if (isset($_GET['del_duda'])) {
    $id = intval($_GET['del_duda']);
    mysqli_query($conexion, "DELETE FROM dudas_pendientes WHERE id = $id");
    header("Location: admin.php?sec=chatbot");
}

// 2. Convertir duda en respuesta oficial
if (isset($_POST['resolver_duda'])) {
    $pregunta = mysqli_real_escape_string($conexion, $_POST['pregunta']);
    $respuesta = mysqli_real_escape_string($conexion, $_POST['respuesta']);
    $id_duda = intval($_POST['id_duda']);

    // Insertamos en la tabla de conocimiento del bot
    $ins = "INSERT INTO chatbot (pregunta, respuesta) VALUES ('$pregunta', '$respuesta')";
    if (mysqli_query($conexion, $ins)) {
        // Si se guarda, borramos la duda de la lista de pendientes
        mysqli_query($conexion, "DELETE FROM dudas_pendientes WHERE id = $id_duda");
    }
    header("Location: admin.php?sec=chatbot&res=ok");
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
    $id = intval($_GET['del_ejercicio']);
    mysqli_query($conexion, "DELETE FROM ejercicio WHERE id_ejercicio = $id");
    header("Location: admin.php?sec=ejercicio");
    exit();
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
    <li><a href="admin.php?sec=chatbot" class="<?= $seccion == 'chatbot' ? 'active' : '' ?>">🤖 Chatbot</a></li>
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
        
        <?php if($seccion == 'chatbot'): ?>
    <h1>Entrenamiento de TERVI</h1>
    
    <div class="card">
        <h2>🧐 Dudas de Usuarios (Sin Respuesta)</h2>
        <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">
            Estas son las preguntas que los usuarios hicieron y el bot no supo contestar. 
            ¡Enséñale la respuesta correcta!
        </p>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Pregunta del Usuario</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dudas = mysqli_query($conexion, "SELECT * FROM dudas_pendientes ORDER BY fecha DESC");
                    if(mysqli_num_rows($dudas) == 0) echo "<tr><td colspan='3'>No hay dudas pendientes. ¡TERVI va por buen camino!</td></tr>";
                    while($d = mysqli_fetch_assoc($dudas)):
                    ?>
                    <tr>
                        <td><strong><?= $d['pregunta_usuario'] ?></strong></td>
                        <td><?= date('d/m/Y H:i', strtotime($d['fecha'])) ?></td>
                        <td>
                            <form method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="id_duda" value="<?= $d['id'] ?>">
                                <input type="hidden" name="pregunta" value="<?= $d['pregunta_usuario'] ?>">
                                <input type="text" name="respuesta" placeholder="Escribe la respuesta médica aquí..." required style="margin-bottom:0; padding: 5px;">
                                <button type="submit" name="resolver_duda" class="btn btn-approve">Enseñar</button>
                                <a href="admin.php?del_duda=<?= $d['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Ignorar esta duda?')">🗑️</a>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2>🧠 Memoria Actual (Base de Conocimientos)</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Palabra Clave / Pregunta</th>
                        <th>Respuesta que da TERVI</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $memoria = mysqli_query($conexion, "SELECT * FROM chatbot ORDER BY pregunta ASC");
                    while($m = mysqli_fetch_assoc($memoria)):
                    ?>
                    <tr>
                        <td style="color: var(--azul-oscuro); font-weight: bold;"><?= $m['pregunta'] ?></td>
                        <td style="font-style: italic; color: #555;"><?= substr($m['respuesta'], 0, 100) ?>...</td>
                        <td>
                            <a href="admin.php?sec=chatbot&del_memoria=<?= $m['id'] ?>" class="btn btn-delete">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php if($seccion == 'ejercicio'): ?>
            <h1>🦾 Gimnasia Terapéutica</h1>
            
            <div class="card">
                <?php include 'formulario_ejercicio.php'; ?>
            </div>

            <div class="card">
                <h2>📋 Ejercicios Publicados</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Ejercicio</th>
                                <th>Dificultad</th>
                                <th>Esquema (S x R)</th>
                                <th>Frecuencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $lista = mysqli_query($conexion, "SELECT * FROM ejercicio ORDER BY id_ejercicio DESC");
                            if(mysqli_num_rows($lista) == 0) echo "<tr><td colspan='5' style='text-align:center;'>No hay ejercicios registrados aún.</td></tr>";
                            while($row = mysqli_fetch_assoc($lista)): 
                                // Color para el badge de dificultad
                                $badge_color = "#27ae60"; // Verde principiante
                                if($row['nivel_dificultad'] == 'Intermedio') $badge_color = "#f39c12"; // Naranja
                                if($row['nivel_dificultad'] == 'Avanzado') $badge_color = "#e74c3c"; // Rojo
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['nombre']) ?></strong></td>
                                <td>
                                    <span style="background: <?= $badge_color ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: bold;">
                                        <?= $row['nivel_dificultad'] ?>
                                    </span>
                                </td>
                                <td><?= $row['series'] ?> sets x <?= $row['repeticiones'] ?> reps</td>
                                <td><?= htmlspecialchars($row['frecuencia']) ?></td>
                                <td>
                                    <a href="admin.php?sec=ejercicio&edit=<?= $row['id_ejercicio'] ?>#form-section" class="btn btn-edit">✏️</a>
                                    <a href="admin.php?del_ejercicio=<?= $row['id_ejercicio'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar este ejercicio?')">🗑️</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>