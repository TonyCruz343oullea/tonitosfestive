<?php
require_once "conexion.php";

$resultado = $conexion->query("SELECT * FROM `cartas` ORDER BY `fecha` DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzón de Cartas - TonitosFestive</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilocarta.css">
    <style>
        .cartas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 22px;
            margin-top: 25px;
        }
        .carta-item {
            background: rgba(10, 20, 15, 0.85);
            border: 1px solid var(--color-secundario);
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 15px rgba(0, 255, 102, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        .carta-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--glow-verde);
            border-color: #00ffaa;
        }
        .carta-autor {
            font-size: 1.4rem;
            color: #ffffff;
            font-family: var(--fuente-titulos);
            border-bottom: 1px dashed rgba(255, 238, 0, 0.3);
            padding-bottom: 8px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .carta-edad {
            font-size: 0.9rem;
            color: var(--color-detalles);
            font-family: var(--fuente-base);
            font-weight: 700;
        }
        .carta-detalle {
            font-size: 0.95rem;
            margin-bottom: 8px;
            color: #e0e0e0;
        }
        .carta-detalle strong {
            color: var(--color-secundario);
        }
        .carta-mensaje-box {
            background: rgba(0, 0, 0, 0.45);
            border-left: 3px solid var(--color-principal);
            padding: 10px 14px;
            border-radius: 4px;
            margin: 12px 0;
            font-style: italic;
            color: #ffffff;
            line-height: 1.5;
        }
        .carta-fecha {
            font-size: 0.8rem;
            color: #888888;
            text-align: right;
            margin-top: 10px;
        }
        .sin-cartas {
            text-align: center;
            padding: 40px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            color: #bbb;
        }
    </style>
</head>
<body>

    <div class="video-container">
        <video autoplay muted loop playsinline id="bg-video">
            <source src="videos/index.mp4" type="video/mp4">
        </video>
    </div>

    <div class="content-overlay">
        <header class="top-section">
            <h1>📜 Cartas Recibidas en el Polo Norte 🎅</h1>
            <p>Mira las cartas enviadas a Santa en la base de datos</p>
            <div class="nav-links">
                <a href="index.html" class="nav-btn">⬅ Volver al Menú</a>
                <a href="carta.php" class="nav-btn">✍️ Escribir Carta</a>
                <a href="Jugeteria.html" class="nav-btn">🎁 Ver Juguetes</a>
            </div>
        </header>

        <main class="main-wrapper">
            <div class="carta-card">
                <div class="card-header">
                    <h2>📬 Buzón Oficial de Santa</h2>
                    <p>Total de cartas registradas en la base de datos: <strong><?php echo $resultado ? $resultado->num_rows : 0; ?></strong></p>
                </div>

                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <div class="cartas-grid">
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <div class="carta-item">
                                <div>
                                    <div class="carta-autor">
                                        <span>🎅 <?php echo htmlspecialchars($fila['nombre']); ?></span>
                                        <span class="carta-edad"><?php echo htmlspecialchars($fila['edad']); ?> años</span>
                                    </div>
                                    <div class="carta-detalle">
                                        <strong>📍 De:</strong> <?php echo htmlspecialchars($fila['ciudad']); ?>
                                    </div>
                                    <div class="carta-detalle">
                                        <strong>⭐ Conducta:</strong> <?php echo htmlspecialchars($fila['comportamiento']); ?>
                                    </div>
                                    <div class="carta-detalle">
                                        <strong>📧 Contacto Papás:</strong> <?php echo htmlspecialchars($fila['correo_de_tus_papas']); ?>
                                    </div>
                                    <div class="carta-detalle">
                                        <strong>🎁 Deseos:</strong> <?php echo htmlspecialchars($fila['deseos']); ?>
                                    </div>
                                    <div class="carta-mensaje-box">
                                        "<?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?>"
                                    </div>
                                </div>
                                <div class="carta-fecha">
                                    🕒 Enviada el: <?php echo date("d/m/Y H:i", strtotime($fila['fecha'])); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="sin-cartas">
                        <h3>📭 Aún no hay cartas registradas</h3>
                        <p style="margin-top: 10px;">¡Sé el primero en enviar tu carta a Santa Claus!</p>
                        <a href="carta.php" class="nav-btn" style="margin-top: 15px; display: inline-block;">Escribir mi Carta Ahora</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer class="bottom-section">
            <h2>Tonitos Festive</h2>
            <p>Página creada por Antonio de Jesus de la Cruz Irgoyen</p>
        </footer>
    </div>

</body>
</html>
