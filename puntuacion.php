<?php
session_start();
include 'config/conexion.php';

if (!isset($_SESSION['user_auth'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Consultas
$sql_total = "SELECT SUM(puntos) as total FROM avance_usuarios WHERE id_usuario = '$id_usuario'";
$res_total = mysqli_query($conexion, $sql_total);
$total_gral = ($res_total) ? mysqli_fetch_assoc($res_total)['total'] : 0;

$sql_rv = "SELECT SUM(puntos) as total_rv FROM avance_usuarios WHERE id_usuario = '$id_usuario' AND tipo_entorno = 'RV'";
$res_rv = mysqli_query($conexion, $sql_rv);
$total_rv = ($res_rv) ? mysqli_fetch_assoc($res_rv)['total_rv'] ?? 0 : 0;

$sql_historial = "SELECT ejercicio_nombre, puntos, tipo_entorno, fecha_registro 
                  FROM avance_usuarios 
                  WHERE id_usuario = '$id_usuario' 
                  ORDER BY fecha_registro DESC LIMIT 10";
$res_historial = mysqli_query($conexion, $sql_historial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Avance - TERVI</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-light: #0056b3;
            --accent: #ffd700;
            --text-main: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --border: #e1e8ed;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: var(--text-main);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Asegura que el footer baje */
        }

        .content-wrapper {
            flex: 1; /* Empuja el footer hacia abajo */
            padding: 40px 20px;
        }

        .container { max-width: 900px; margin: auto; }

        /* Estilos de Tarjetas y Secciones */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 20px;
        }
        .header-section h1 { margin: 0; color: var(--primary-dark); font-size: 1.8rem; }

        .premium-card {
            background: linear-gradient(to right, #003d7a, #0056b3);
            border-radius: 12px;
            color: var(--white);
            padding: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 61, 122, 0.15);
            margin-bottom: 30px;
        }
        .premium-card::after {
            content: "\f724"; font-family: "Font Awesome 6 Free"; font-weight: 900;
            position: absolute; right: -20px; bottom: -20px; font-size: 12rem; opacity: 0.1;
        }

        .points-large { font-size: 4.5rem; font-weight: 200; margin: 10px 0; }

        .metrics-container {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px; margin-bottom: 40px;
        }
        .metric-item {
            background: var(--white); border: 1px solid var(--border);
            padding: 25px; border-radius: 8px;
        }

        .history-section { background: var(--white); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; }
        .history-header { padding: 20px; background: #fafbfc; border-bottom: 1px solid var(--border); font-weight: bold; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px 20px; color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; }
        td { padding: 18px 20px; border-bottom: 1px solid #f1f5f9; }

        .badge-rv { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
        .badge-web { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="content-wrapper">
    <div class="container">
        <div class="header-section">
            <div>
                <h1>Reporte de Evolución</h1>
                <p style="color: var(--text-light); margin: 5px 0 0 0;">Paciente: <?php echo $_SESSION['nombre_usu']; ?></p>
            </div>
        </div>

        <div class="premium-card">
            <p style="text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Rendimiento Realidad Virtual</p>
            <div class="points-large"><?php echo number_format($total_rv); ?> <span style="font-size: 1.5rem; opacity: 0.7;">Puntos RV</span></div>
            <p style="opacity: 0.9;">Meta clínica: 5,000 pts para certificación de movilidad completa.</p>
        </div>

        <div class="metrics-container">
            <div class="metric-item">
                <div style="color: var(--text-light); font-size: 0.8rem; font-weight: 600;">PUNTAJE ACUMULADO</div>
                <div style="font-size: 1.5rem; font-weight: 700;"><?php echo number_format($total_gral); ?></div>
            </div>
            <div class="metric-item">
                <div style="color: var(--text-light); font-size: 0.8rem; font-weight: 600;">ESTATUS</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #15803d;">Activo</div>
            </div>
            <div class="metric-item">
                <div style="color: var(--text-light); font-size: 0.8rem; font-weight: 600;">NIVEL</div>
                <div style="font-size: 1.5rem; font-weight: 700;">Fase <?php echo ($total_rv > 1000) ? 'II' : 'I'; ?></div>
            </div>
        </div>

        <div class="history-section">
            <div class="history-header">Historial Reciente de Sesiones</div>
            <table>
                <thead>
                    <tr>
                        <th>Ejercicio</th>
                        <th>Impacto</th>
                        <th>Metodología</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($res_historial)): ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo $row['ejercicio_nombre']; ?></td>
                        <td style="color: var(--primary-light); font-weight: bold;">+<?php echo $row['puntos']; ?> pts</td>
                        <td>
                            <span class="<?php echo ($row['tipo_entorno'] == 'RV') ? 'badge-rv' : 'badge-web'; ?>">
                                <?php echo ($row['tipo_entorno'] == 'RV') ? 'ENTORNO RV' : 'SISTEMA WEB'; ?>
                            </span>
                        </td>
                        <td style="color: var(--text-light); font-size: 0.85rem;">
                            <?php echo date('d M, Y', strtotime($row['fecha_registro'])); ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>