<?php
session_start();
require 'vendor/autoload.php';

use Philo\Blade\Blade;

$views = "views";
$cache = "cache";

// Crear directorio de caché si no existe
if (!is_dir($cache)) {
    mkdir($cache, 0755, true);
}

$blade = new Blade($views, $cache);

$titulo = 'Sistema de Notas';
$encabezado = 'Bienvenido';
$ruta_js = "js/index.js";

// Mensajes de sesión
$success_msg = $_SESSION['success'] ?? null;
$error_msg = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

echo $blade
    ->view()
    ->make('index', compact('titulo', 'encabezado', 'ruta_js', 'success_msg', 'error_msg'))
    ->render();
?>