<?php
session_start();
require '../vendor/autoload.php';


use Philo\Blade\Blade;


$client = new Google\Client;

$client->setClientId("TU_GOOGLE_CLIENT_ID");
$client->setClientSecret("TU_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://localhost/tu_proyecto/src/validate_register.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();


$views ="../views";
$cache ="../cache";
$blade = new Blade($views,$cache);

$titulo = 'Registro';
$encabezado ='Registrar Usuario';
$ruta_js ="../js/register.js";

$success_google_msg = $_SESSION['success_google_msg'] ?? null;
unset($_SESSION['success_google_msg']);

$error_google_msg = $_SESSION['error_google_msg'] ?? null;
unset( $_SESSION['error_google_msg']);

echo $blade
    ->view()
    ->make('register',compact('titulo','encabezado','url','success_google_msg','error_google_msg','ruta_js'))
    ->render();
