<?php 
include 'includes/header.php'; 
$conexion = mysqli_connect("localhost", "root", "", "rv_rehabilitacion");
$query_conceptos = mysqli_query($conexion, "SELECT * FROM contenidos WHERE tipo_contenido = 'Concepto' ORDER BY id_contenido ASC");
$query_info = mysqli_query($conexion, "SELECT * FROM contenidos WHERE tipo_contenido = 'Guía' ORDER BY id_contenido ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TERVI - Guía Visual</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul-tervi: #0056b3;
            --celeste: #5dade2;
            --gris-claro: #f8f9fa;
            --texto: #2c3e50;
        }

        body { font-family: 'Poppins', sans-serif; background: #fff; color: var(--texto); margin: 0; }

        /* Hero Moderno con Degradado */
        .hero-rehab {
            background: linear-gradient(135deg, var(--azul-tervi), var(--celeste));
            color: white;
            padding: 100px 20px;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%);
        }

        .container { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }

        /* Estilo Zig-Zag para Guías */
        .guia-row {
            display: flex;
            align-items: center;
            gap: 50px;
            margin-bottom: 80px;
        }
        .guia-row:nth-child(even) { flex-direction: row-reverse; }

        .guia-img {
            flex: 1;
            height: 350px;
            background-size: cover;
            background-position: center;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .guia-info { flex: 1; }
        .guia-info h2 { color: var(--azul-tervi); font-size: 2rem; margin-bottom: 20px; }
        .guia-info p { font-size: 1.1rem; line-height: 1.8; color: #5d6d7e; }

        /* Grid de Conceptos Rápidos */
        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 50px;
        }
        .mini-card {
            background: var(--gris-claro);
            padding: 25px;
            border-radius: 20px;
            border-bottom: 4px solid var(--celeste);
            transition: 0.3s;
        }
        .mini-card:hover { background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transform: translateY(-5px); }

        @media (max-width: 850px) {
            .guia-row, .guia-row:nth-child(even) { flex-direction: column; text-align: center; }
            .guia-img { width: 100%; height: 250px; }
        }
    </style>
</head>
<body>

<section class="hero-rehab">
    <h1>Centro de Aprendizaje TERVI</h1>
    <p>Guías visuales y conceptos clave para tu proceso de recuperación</p>
</section>

<div class="container">
    <h2 style="text-align:center; color: var(--azul-tervi); margin-bottom: 60px;">📘 Guías de Especialidad</h2>

    <?php 
    $contador = 0;
    while($i = mysqli_fetch_assoc($query_info)): 
        // Aquí puedes alternar imágenes de tu carpeta assets/img/
        $img_name = ($contador % 2 == 0) ? 'rehab1.jpg' : 'rehab2.jpg';
    ?>
    <div class="guia-row">
        <div class="guia-img" style="background-image: url('assets/img/<?php echo $img_name; ?>');"></div>
        <div class="guia-info">
            <h2><?php echo htmlspecialchars($i['titulo']); ?></h2>
            <p><?php echo nl2br($i['descripcion']); ?></p>
        </div>
    </div>
    <?php $contador++; endwhile; ?>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 80px 0;">

    <h2 style="text-align:center; color: var(--azul-tervi);">🧠 Glosario Rápido</h2>
    <div class="grid-cards">
        <?php while($c = mysqli_fetch_assoc($query_conceptos)): ?>
        <div class="mini-card">
            <h3 style="color:var(--azul-tervi)"><?php echo htmlspecialchars($c['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($c['descripcion']); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>