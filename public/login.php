<?php
session_start();
require '../vendor/autoload.php';

use Philo\Blade\Blade;

$client = new Google\Client;

$client->setClientId("TU_GOOGLE_CLIENT_ID");
$client->setClientSecret("TU_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://localhost/tu_proyecto/src/validate_login.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

$views ="../views";
$cache ="../cache";
$blade = new Blade($views,$cache);

$titulo = 'Inicio sesión';
$encabezado ='Iniciar Sesión';
$ruta_js ="../js/login.js";

$error =$_SESSION['error'] ?? null;
unset($_SESSION['error']);

echo $blade
    ->view()
    ->make('login',compact('titulo','encabezado','url','error','ruta_js'))
    ->render();
