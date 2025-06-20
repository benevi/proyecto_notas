<?php
session_start();

require_once '../vendor/autoload.php';
require_once __DIR__ . "/../include/Helper.php";

use ProyectoNotas\Conexion;


$metodoRegistro = isset($_GET['code']) ? 'google' : 'normal';


//Login mediante google auth
if($metodoRegistro === 'google'){

    try {
        $client = new Google\Client();
        $client->setClientId("TU_GOOGLE_CLIENT_ID");
        $client->setClientSecret("TU_GOOGLE_CLIENT_SECRET");
        $client->setRedirectUri("http://localhost/tu_proyecto/src/validate_login.php");
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
        
     
        $email = $userinfo->email;

        // Registrar el usuario
        loginUsuarioGoogle($email);
        
    } catch (Exception $e) {
        exit("Error en autenticación Google: " . $e->getMessage());
    }
}


//Login de manera manual
if($_SERVER['REQUEST_METHOD'] ==='POST'){
    $email = trim(htmlspecialchars($_POST['email']));
    $password =trim($_POST['password']);
    loginUsuarioNormal($email,$password);

}


//Se usa dos tipos de funciones de login porque el de google no acepta ajax ya que recarga la página siempre
function loginUsuarioNormal(string $e, string $p){  
    $conexion = new Conexion();
    $pdo = $conexion->crearConexion();

    $stmt = $pdo->prepare("SELECT id,nombre,password FROM usuarios WHERE email = :email");
    $stmt->execute(['email'=>$e]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($usuario){
        if(password_verify($p,$usuario['password'])){
        $_SESSION['id_usuario'] = $usuario['id'];
         $_SESSION['usuario'] = $usuario['nombre'];
         Helper::jsonOutput(0,"El usuario se ha logueado"); 
        }
        else{
            Helper::jsonOutput(2,"La contraseña es incorrecta"); 
        }
        
    }
    else{
        Helper::jsonOutput(1,"El usuario no está registrado");     
    }
}


function loginUsuarioGoogle(string $e){  
    $conexion = new Conexion();
    $pdo = $conexion->crearConexion();

    $stmt = $pdo->prepare("SELECT id,nombre,password FROM usuarios WHERE email = :email");
    $stmt->execute(['email'=>$e]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($usuario){
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['usuario'] =$usuario['nombre'];
         
         header("Location:../public/dashboard.php");
        }
        else{
           $_SESSION['error'] ="El usuario no está registrado";
        }
        
    }



