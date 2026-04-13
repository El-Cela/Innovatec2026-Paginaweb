<?php 
// 1. Lógica de carga de datos (Se activa si Mercedes pulsa el botón de editar ✏️)
$datos_ejercicio = [
    'nombre' => '', 
    'descripcion' => '', 
    'series' => 3, 
    'repeticiones' => 10, 
    'frecuencia' => 'Diario', 
    'nivel_dificultad' => 'Principiante', 
    'precauciones' => '',
    'id_categoria' => 1
];

$id_ejercicio_form = 0;
$texto_boton = "🚀 Guardar Ejercicio";
$color_alerta = "#5dade2"; // Azul por defecto

if (isset($_GET['edit'])) {
    $id_ejercicio_form = intval($_GET['edit']);
    $res_edicion = mysqli_query($conexion, "SELECT * FROM ejercicio WHERE id_ejercicio = $id_ejercicio_form");
    if ($res_edicion && mysqli_num_rows($res_edicion) > 0) {
        $datos_ejercicio = mysqli_fetch_assoc($res_edicion);
        $texto_boton = "📝 Actualizar Ejercicio";
        $color_alerta = "#f39c12"; // Naranja para indicar edición
    }
}
?>

<style>
    .ejercicio-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        padding: 10px;
    }

    .full-width { grid-column: span 2; }

    .form-group-ej {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-ej label {
        font-weight: 700;
        color: #2c3e50;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group-ej input, 
    .form-group-ej select, 
    .form-group-ej textarea {
        padding: 14px;
        border: 2px solid #eef2f7;
        border-radius: 12px;
        font-size: 1rem;
        background: #fbfcfe;
        transition: all 0.3s ease;
        box-sizing: border-box; /* Evita que se amontone como en la captura */
    }

    .form-group-ej input:focus, .form-group-ej select:focus, .form-group-ej textarea:focus {
        border-color: #5dade2;
        background: #fff;
        outline: none;
        box-shadow: 0 4px 12px rgba(93, 173, 226, 0.1);
    }

    .btn-submit-ej {
        background: <?= $color_alerta ?>;
        color: white;
        border: none;
        padding: 18px;
        border-radius: 15px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-submit-ej:hover {
        transform: translateY(-3px);
        filter: brightness(1.1);
    }

    .precaucion-input {
        border-color: #fadbd8 !important;
    }
</style>

<div class="card" id="form-section">
    <h2 style="margin-top:0; color: #2e86c1; font-size: 1.4rem;">
        <?= isset($_GET['edit']) ? '✏️ Editando Ejercicio' : '✨ Nuevo Ejercicio Terapéutico' ?>
    </h2>
    <p style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 25px;">
        Completa los campos para actualizar el gimnasio virtual de <strong>MinndTeen</strong>.
    </p>

    <form action="procesos/procesar_ejercicio.php" method="POST" enctype="multipart/form-data" class="ejercicio-container">
        <input type="hidden" name="id_ejercicio" value="<?= $id_ejercicio_form ?>">

        <div class="form-group-ej full-width">
            <label>Nombre del Ejercicio / Actividad</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($datos_ejercicio['nombre']) ?>" required placeholder="Ej: Flexión isométrica de cadera">
        </div>

        <div class="form-group-ej">
            <label>Nivel de Dificultad</label>
            <select name="nivel_dificultad">
                <option value="Principiante" <?= $datos_ejercicio['nivel_dificultad'] == 'Principiante' ? 'selected' : '' ?>>🟢 Principiante (Fácil)</option>
                <option value="Intermedio" <?= $datos_ejercicio['nivel_dificultad'] == 'Intermedio' ? 'selected' : '' ?>>🟡 Intermedio (Medio)</option>
                <option value="Avanzado" <?= $datos_ejercicio['nivel_dificultad'] == 'Avanzado' ? 'selected' : '' ?>>🔴 Avanzado (Difícil)</option>
            </select>
        </div>

        <div class="form-group-ej">
            <label>Frecuencia Recomendada</label>
            <input type="text" name="frecuencia" value="<?= htmlspecialchars($datos_ejercicio['frecuencia']) ?>" placeholder="Ej: 3 veces por semana">
        </div>

        <div class="form-group-ej">
            <label>Número de Series</label>
            <input type="number" name="series" value="<?= $datos_ejercicio['series'] ?>" min="1">
        </div>

        <div class="form-group-ej">
            <label>Repeticiones por Serie</label>
            <input type="number" name="repeticiones" value="<?= $datos_ejercicio['repeticiones'] ?>" min="1">
        </div>

        <div class="form-group-ej full-width">
            <label>📖 Descripción Técnica (Paso a paso)</label>
            <textarea name="descripcion" rows="4" required placeholder="Explica cómo realizar el movimiento..."><?= htmlspecialchars($datos_ejercicio['descripcion']) ?></textarea>
        </div>

        <div class="form-group-ej full-width">
            <label>⚠️ Precauciones y Contraindicaciones</label>
            <textarea name="precauciones" rows="2" class="precaucion-input" placeholder="Ej: Evitar si existe dolor agudo en la zona lumbar..."><?= htmlspecialchars($datos_ejercicio['precauciones']) ?></textarea>
        </div>

        <div class="form-group-ej full-width">
            <label>📸 Imagen de Referencia</label>
            <input type="file" name="imagen_guia" accept="image/*">
            <small style="color: #95a5a6;">Formatos recomendados: JPG o PNG. Tamaño máximo 2MB.</small>
        </div>

        <div class="full-width" style="margin-top: 10px; display: flex; gap: 15px;">
            <button type="submit" name="guardar_ejercicio" class="btn-submit-ej" style="flex: 2;">
                <?= $texto_boton ?>
            </button>
            <?php if(isset($_GET['edit'])): ?>
                <a href="admin.php?sec=ejercicios" style="flex: 1; text-decoration:none; background:#ecf0f1; color:#7f8c8d; display:flex; align-items:center; justify-content:center; border-radius:15px; font-weight:bold;">
                    Cancelar
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>