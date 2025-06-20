<?php
session_start();
require '../vendor/autoload.php';

use Philo\Blade\Blade;

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
}


$views ="../views";
$cache ="../cache";
$blade = new Blade($views,$cache);

$titulo = 'Dashboard';
$encabezado ='Página Principal';
$usuario =$_SESSION['usuario'];
$ruta_js ="../js/dashboard.js";

echo $blade
    ->view()
    ->make('dashboard',compact('titulo','encabezado','usuario','ruta_js'))
    ->render();
