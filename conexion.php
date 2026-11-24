<?php

$servidor   = "localhost";
$usuario_bd = "root";
$password_bd = "";
$nombre_bd  = "navidad_antonio";


$conexion = new mysqli($servidor, $usuario_bd, $password_bd);


if ($conexion->connect_error) {
    die("Error crítico al conectar con el servidor MySQL de XAMPP: " . $conexion->connect_error . 
        "<br>Por favor, asegúrate de que el módulo MySQL esté encendido (Start) en tu panel de control de XAMPP.");
}

$sql_crear_bd = "CREATE DATABASE IF NOT EXISTS `$nombre_bd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$conexion->query($sql_crear_bd)) {
    die("Error al verificar/crear la base de datos: " . $conexion->error);
}


$conexion->select_db($nombre_bd);
$conexion->set_charset("utf8mb4");


$sql_crear_tabla = "CREATE TABLE IF NOT EXISTS `cartas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `edad` INT NOT NULL,
    `ciudad` VARCHAR(100) NOT NULL,
    `comportamiento` VARCHAR(60) NOT NULL,
    `deseos` TEXT NOT NULL,
    `mensaje` TEXT NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (!$conexion->query($sql_crear_tabla)) {
    die("Error al verificar/crear la tabla de cartas: " . $conexion->error);
}
?>
