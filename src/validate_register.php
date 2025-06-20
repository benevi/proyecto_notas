<?php
session_start();

require_once '../vendor/autoload.php';
require_once __DIR__ . "/../include/Helper.php";

use ProyectoNotas\Conexion;

//REGISTRO CON GOOGLE

$metodoRegistro = isset($_GET['code']) ? 'google' : 'normal';

if($metodoRegistro === 'google'){

    try {
        $client = new Google\Client();
        $client->setClientId("TU_GOOGLE_CLIENT_ID");
        $client->setClientSecret("TU_GOOGLE_CLIENT_SECRET");
        $client->setRedirectUri("http://localhost/tu_proyecto/src/validate_register.php");
        $client->addScope("email");
        $client->addScope("profile");
        
        // Verificar código de autorización
        if (!isset($_GET['code'])) {
            exit("Error: No se recibió código de autorización");
        }
        
        // Obtener token de acceso
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            exit("Error al obtener token: " . $token['error_description']);
        }
        
        // Establecer token de acceso
        $client->setAccessToken($token);
        
        // Obtener información del usuario
        $oauth = new Google\Service\Oauth2($client);
        $userinfo = $oauth->userinfo->get();
        
        // Configurar datos para registro
        $nombre = $userinfo->name;
        $email = $userinfo->email;
        $randomPass = bin2hex(random_bytes(16));
        $hashPassword = password_hash($randomPass, PASSWORD_DEFAULT);
        
        // Registrar el usuario
        registroUsuario($nombre, $email, $hashPassword,'google');
        
    } catch (Exception $e) {
        exit("Error en autenticación Google: " . $e->getMessage());
    }
}
//REGISTRO NORMAL
elseif($_SERVER['REQUEST_METHOD'] ==='POST'){
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim($_POST['password']);

    $hashPassword = password_hash($password,PASSWORD_DEFAULT);
    registroUsuario($nombre,$email,$hashPassword,'normal');
}



function registroUsuario(string $n,string $e, string $p,string $metodoRegistro){
    
    $conexion = new Conexion();
    $pdo = $conexion->crearConexion();

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre = :nombre OR email = :email");
    $stmt->execute(['nombre'=> $n, 'email'=>$e]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($usuario){
        if($metodoRegistro === 'google'){
            $_SESSION['error_google_msg'] = "El usuario ya está registrado";
            header("Location: ../public/register.php");
        }else{
            Helper::jsonOutput(1,"El usuario ya está registrado");
        }
      
    }
    else{

        $stmt = $pdo->prepare("INSERT INTO usuarios(nombre,email,password) VALUES (:nombre,:email,:password)");
        $stmt->execute(['nombre'=> $n, 'email'=>$e,'password'=>$p]);

        if($metodoRegistro === 'google'){
            $_SESSION['success_google_msg'] = "El usuario se ha registrado con éxito.";
            header("Location: ../public/register.php");
        }else{
        Helper::jsonOutput(0,"El usuario se ha registrado con éxito. Redirigiendo a iniciar sesión.");     
        }
    }
}



