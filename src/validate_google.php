php<?php
session_start();

require '../vendor/autoload.php';

// Configuración del cliente de Google
$client = new Google\Client();
$client->setClientId("TU_GOOGLE_CLIENT_ID");
$client->setClientSecret("TU_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://localhost/tu_proyecto/src/validate_google.php");
$client->addScope("email");
$client->addScope("profile");

try {
    // Verificar si hay un código de autorización
    if(!isset($_GET['code'])) {
        exit("Error: No se recibió código de autorización. Login fallido.");
    }

    // Obtener token de acceso
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if(isset($token['error'])) {
        exit("Error al obtener token: " . $token['error_description']);
    }
    
    // Establecer token de acceso
    $client->setAccessToken($token);
    
    // Obtener información del usuario
    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();
    
    //Guardar los datos en sesión
    $_SESSION['usuario'] = $userinfo->name;
    $_SESSION['email'] = $userinfo->email;
    $_SESSION['google_id'] = $userinfo->id;
    $_SESSION['auth_type'] = 'google';
    

} catch (Exception $e) {
    // Manejar cualquier error que ocurra
    exit("Error: " . $e->getMessage());
}
?>