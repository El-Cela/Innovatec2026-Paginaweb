<?php 
session_start();
include 'config/conexion.php'; 

// Protección de sesión
if (!isset($_SESSION['admin_auth'])) {
    header("Location: admin.php");
    exit();
}

$titulo_form = "✨ Agregar Nuevo Contenido";
$datos = ['titulo' => '', 'descripcion' => '', 'tipo_contenido' => 'Concepto', 'slug' => '', 'imagen_url' => ''];
$id_form = 0;
$seccion = 'conceptos';

if (isset($_GET['edit'])) {
    $id_form = intval($_GET['edit']);
    $res = mysqli_query($conexion, "SELECT * FROM contenidos WHERE id_contenido = $id_form");
    $datos = mysqli_fetch_assoc($res);
    $titulo_form = "📝 Modificar Contenido";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editor TERVI - <?= $titulo_form ?></title>
    <style>
        :root { --azul-oscuro: #2e86c1; --azul-claro: #5dade2; --bg: #f4f9ff; --sidebar-width: 250px; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; display: flex; }
        
        /* Barra Lateral (Sidebar) */
        .sidebar { width: var(--sidebar-width); background: white; height: 100vh; position: fixed; border-right: 1px solid #e1e8ed; display: flex; flex-direction: column; }
        .sidebar-header { padding: 30px 20px; text-align: center; color: var(--azul-oscuro); font-weight: bold; font-size: 1.2rem; border-bottom: 1px solid #eee; }
        .nav-links { list-style: none; padding: 0; margin: 20px 0; }
        .nav-links li a { display: block; padding: 15px 25px; text-decoration: none; color: #5d6d7e; transition: 0.3s; border-left: 4px solid transparent; }
        .nav-links li a:hover { background: #f0f7ff; color: var(--azul-oscuro); }
        .nav-links li a.active { background: #ebf5fb; color: var(--azul-oscuro); border-left: 4px solid var(--azul-oscuro); font-weight: bold; }

        /* Contenido */
        .main-content { flex: 1; margin-left: var(--sidebar-width); padding: 40px; }
        .card { background: white; border-radius: 20px; padding: 35px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
        
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 10px; color: #34495e; }
        .form-group input[type="text"], .form-group select, .form-group textarea { 
            width: 100%; padding: 12px; border: 1.5px solid #d6eaf8; border-radius: 10px; box-sizing: border-box; font-size: 1rem;
        }
        
        /* Zonas de Carga (Imagen y Audio) */
        .upload-zone {
            background: #f8fbff; border: 2px dashed var(--azul-claro); border-radius: 15px; padding: 20px; text-align: center; transition: 0.3s;
        }
        .upload-zone:hover { background: #ebf5fb; border-color: var(--azul-oscuro); }
        .upload-zone input { cursor: pointer; }
        
        .btn-save { 
            background: var(--azul-oscuro); color: white; border: none; padding: 15px; border-radius: 12px; 
            width: 100%; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s;
        }
        .btn-save:hover { background: #21618c; transform: translateY(-2px); }
        
        .preview-media { margin-top: 10px; border-radius: 10px; border: 1px solid #eee; padding: 10px; background: white; }
        
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">💙 MinndTeen Admin</div>
        <ul class="nav-links" style="height: calc(100% - 100px); display: flex; flex-direction: column;">
    <li><a href="admin.php?sec=videos" class="<?= $seccion == 'videos' ? 'active' : '' ?>">🎥 Gestión de Videos</a></li>
    <li><a href="admin.php?sec=conceptos" class="<?= $seccion == 'conceptos' ? 'active' : '' ?>">🧠 Diccionario / Temas</a></li>
    <li><a href="admin.php?sec=comentarios" class="<?= $seccion == 'comentarios' ? 'active' : '' ?>">💬 Comentarios</a></li>
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
        <h1 style="text-align:center; color:#2c3e50;"><?= $titulo_form ?></h1>

        <div class="card">
         <form action="procesos/procesar_contenido.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_contenido" value="<?= $id_form ?>">

                <div class="form-group">
                    <label>Título del Contenido</label>
                    <input type="text" name="titulo" value="<?= $datos['titulo'] ?>" required placeholder="Ej: Higiene del Muñón">
                </div>

                <div class="form-group">
                    <label>Tipo de Formato</label>
                    <select name="tipo_contenido">
                        <option value="Concepto" <?= $datos['tipo_contenido'] == 'Concepto' ? 'selected' : '' ?>>Concepto (Tarjeta)</option>
                        <option value="Guía" <?= $datos['tipo_contenido'] == 'Guía' ? 'selected' : '' ?>>Guía (Largo con multimedia)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Descripción / Cuerpo del Texto</label>
                    <textarea name="descripcion" required placeholder="Describe el proceso o concepto..."><?= $datos['descripcion'] ?></textarea>
                </div>

                <div class="form-group">
                    <label>🖼️ Imagen Ilustrativa</label>
                    <div class="upload-zone">
                        <?php if(!empty($datos['imagen_url'])): ?>
                            <div class="preview-media">
                                <small>Actual:</small><br>
                                <img src="../assets/img/<?= $datos['imagen_url'] ?>" width="100">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="imagen" accept="image/*">
                        <small style="display:block; margin-top:5px; color:#7f8c8d;">Formatos: JPG, PNG</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Slug (URL amigable)</label>
                    <input type="text" name="slug" value="<?= $datos['slug'] ?>" placeholder="ej: cuidados-basicos">
                </div>

                <button type="submit" name="procesar_contenido" class="btn-save">🚀 Guardar Contenido</button>
                
                <a href="admin.php?sec=conceptos" style="display:block; text-align:center; margin-top:20px; color:#95a5a6; text-decoration:none;">← Volver sin guardar</a>
            </form>
        </div>
    </div>
</body>
</html>