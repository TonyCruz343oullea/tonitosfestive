<?php 
require_once "conexion.php"; 

$alerta = ""; 
$tipo_alerta = ""; 
$nombre = ""; 
$edad = ""; 
$ciudad = ""; 
$comportamiento = ""; 
$deseos = ""; 
$mensaje = ""; 
$correo_de_tus_papas = ""; 

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : ""; 
    $edad = isset($_POST["edad"]) ? intval($_POST["edad"]) : 0; 
    $ciudad = isset($_POST["ciudad"]) ? trim($_POST["ciudad"]) : ""; 
    $comportamiento = isset($_POST["comportamiento"]) ? trim($_POST["comportamiento"]) : ""; 
    $deseos = isset($_POST["deseos"]) ? trim($_POST["deseos"]) : ""; 
    $mensaje = isset($_POST["mensaje"]) ? trim($_POST["mensaje"]) : ""; 
    $correo_de_tus_papas = isset($_POST["correo_de_tus_papas"]) ? trim($_POST["correo_de_tus_papas"]) : ""; 

    if (empty($nombre) || $edad <= 0 || empty($ciudad) || empty($comportamiento) || empty($deseos) || empty($mensaje) || empty($correo_de_tus_papas)) { 
        $tipo_alerta = "error"; 
        $alerta = "⚠️ Por favor, llena todos los campos de la carta para que Santa y los duendes puedan leerla completa."; 
    } else { 
        $sql = "INSERT INTO `cartas` (`nombre`, `edad`, `ciudad`, `comportamiento`, `deseos`, `mensaje`, `correo_de_tus_papas`) VALUES (?, ?, ?, ?, ?, ?, ?)"; 
        $stmt = $conexion->prepare($sql); 
        
        if ($stmt) { 
            $stmt->bind_param("sisssss", $nombre, $edad, $ciudad, $comportamiento, $deseos, $mensaje, $correo_de_tus_papas); 
            
            if ($stmt->execute()) { 
                $tipo_alerta = "exito"; 
                $alerta = "🎅✨ ¡Felicidades! Tu carta ha sido enviada y guardada con éxito en el buzón del Polo Norte."; 
                $nombre = ""; 
                $edad = ""; 
                $ciudad = ""; 
                $comportamiento = ""; 
                $deseos = ""; 
                $mensaje = ""; 
                $correo_de_tus_papas = ""; 
            } else { 
                $tipo_alerta = "error"; 
                $alerta = "❌ Ocurrió un error al guardar tu carta: " . htmlspecialchars($stmt->error); 
            } 
            $stmt->close(); 
        } else { 
            $tipo_alerta = "error"; 
            $alerta = "❌ Error en la preparación de la consulta: " . htmlspecialchars($conexion->error); 
        } 
    } 
} 
?> 
<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Escribe tu Carta a Santa - TonitosFestive</title> 
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/estilocarta.css"> 
</head> 
<body> 
    <div class="video-container"> 
        <video autoplay muted loop playsinline id="bg-video"> 
            <source src="videos/index.mp4" type="video/mp4"> 
        </video> 
    </div> 
    <div class="content-overlay"> 
        <header class="top-section"> 
            <h1>🎅 Escribe tu Carta a Santa 🎄</h1> 
            <p>Envía tus deseos directamente a la base de datos del Polo Norte</p> 
            <div class="nav-links"> 
                <a href="index.html" class="nav-btn">⬅ Volver al Menú</a> 
                <a href="Jugeteria.html" class="nav-btn">🎁 Ver Juguetes</a> 
                <a href="ListaDeseos.php" class="nav-btn">📜 Lista de Deseos</a> 
            </div> 
        </header> 
        <main class="main-wrapper"> 
            <div class="carta-card"> 
                <div class="card-header"> 
                    <h2>✉️ Carta Oficial para Santa Claus</h2> 
                    <p>Completa tus datos con sinceridad para que los duendes preparen tu regalo especial.</p> 
                </div> 
                
                <?php if (!empty($alerta)): ?> 
                    <div class="alerta alerta-<?php echo $tipo_alerta === 'exito' ? 'exito' : 'error'; ?>"> 
                        <span><?php echo $alerta; ?></span> 
                    </div> 
                <?php endif; ?> 
                
                <form action="carta.php" method="POST" autocomplete="off"> 
                    <div class="form-grid"> 
                        <div class="form-group"> 
                            <label for="nombre"> 
                                <span class="emoji">👤</span> Tu Nombre Completo: 
                            </label> 
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej. Antonio de Jesús" value="<?php echo htmlspecialchars($nombre); ?>" required > 
                        </div> 
                        <div class="form-group"> 
                            <label for="edad"> 
                                <span class="emoji">🎂</span> Tu Edad: 
                            </label> 
                            <input type="number" id="edad" name="edad" class="form-control" min="1" max="120" placeholder="Ej. 10" value="<?php echo $edad > 0 ? htmlspecialchars($edad) : ''; ?>" required > 
                        </div> 
                        <div class="form-group"> 
                            <label for="ciudad"> 
                                <span class="emoji">📍</span> ¿Dónde vives? (Ciudad / País): 
                            </label> 
                            <input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Ej. Villahermosa, Tabasco" value="<?php echo htmlspecialchars($ciudad); ?>" required > 
                        </div> 
                        <div class="form-group"> 
                            <label for="comportamiento"> 
                                <span class="emoji">⭐</span> ¿Cómo te portaste este año? 
                            </label> 
                            <select id="comportamiento" name="comportamiento" class="form-control" required> 
                                <option value="" disabled <?php echo empty($comportamiento) ? 'selected' : ''; ?>>Selecciona una opción...</option> 
                                <option value="¡Excelente! Fui un angelito 😇" <?php echo $comportamiento === '¡Excelente! Fui un angelito 😇' ? 'selected' : ''; ?>>¡Excelente! Fui un angelito 😇</option> 
                                <option value="Muy bien, hice todas mis tareas 📚" <?php echo $comportamiento === 'Muy bien, hice todas mis tareas 📚' ? 'selected' : ''; ?>>Muy bien, hice todas mis tareas 📚</option> 
                                <option value="Bien, con algunas travesuras pero buen corazón 🤪" <?php echo $comportamiento === 'Bien, con algunas travesuras pero buen corazón 🤪' ? 'selected' : ''; ?>>Bien, con algunas travesuras pero buen corazón 🤪</option> 
                                <option value="Prometo mejorar el próximo año 🤞" <?php echo $comportamiento === 'Prometo mejorar el próximo año 🤞' ? 'selected' : ''; ?>>Prometo mejorar el próximo año 🤞</option> 
                            </select> 
                        </div> 
                        <div class="form-group col-full"> 
                            <label for="correo_de_tus_papas"> 
                                <span class="emoji">📧</span> Correo electrónico de tus papás: 
                            </label> 
                            <input type="email" id="correo_de_tus_papas" name="correo_de_tus_papas" class="form-control" placeholder="Ej. papas@correo.com" value="<?php echo htmlspecialchars($correo_de_tus_papas); ?>" required > 
                        </div> 
                        <div class="form-group col-full"> 
                            <label for="deseos"> 
                                <span class="emoji">🎁</span> ¿Qué juguetes o regalos te gustaría recibir? 
                            </label> 
                            <input type="text" id="deseos" name="deseos" class="form-control" placeholder="Ej. Carrito a control remoto, pista de carreras y un libro de cuentos" value="<?php echo htmlspecialchars($deseos); ?>" required > 
                        </div> 
                        <div class="form-group col-full"> 
                            <label for="mensaje"> 
                                <span class="emoji">📝</span> Mensaje o carta para Santa: 
                            </label> 
                            <textarea id="mensaje" name="mensaje" class="form-control" rows="5" placeholder="Querido Santa, este año he aprendido mucho y quiero agradecerte por..." required ><?php echo htmlspecialchars($mensaje); ?></textarea> 
                        </div> 
                    </div> 
                    <div class="btn-submit-container"> 
                        <button type="submit" class="btn-enviar"> 
                            🚀 Enviar mi Carta a Santa Claus ✨ 
                        </button> 
                    </div> 
                </form> 
            </div> 
        </main> 
        <footer class="bottom-section"> 
            <h2>Tonitos Festive</h2> 
            <p>Página creada por Antonio de Jesus de la Cruz Irgoyen • Conexión Segura MySQL</p> 
        </footer> 
    </div> 
</body> 
</html>
