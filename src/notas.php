<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . "/../include/Helper.php";

use ProyectoNotas\Conexion;

//Si el usuario no está logeado
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];



//Función para crear las notas en la base de datos 
function crearNota($titulo,$contenido,$id_usuario){
    $conexion = new Conexion();
    $pdo =$conexion->crearConexion();

    $stmt =$pdo->prepare("INSERT INTO notas(id_usuario,titulo,contenido) VALUES(:id_usuario,:titulo,:contenido)");
    $stmt->execute(['id_usuario' => $id_usuario, 'titulo'=>$titulo,'contenido'=>$contenido]);
    Helper::jsonOutput(0,"La nota se ha creado con éxito");
}



//Función para seleccionar todas las notas del usuario
function mostrarNotas($id){
    $conexion = new Conexion();
    $pdo =$conexion->crearConexion();

    $stmt = $pdo->prepare("SELECT id,titulo,contenido,fecha_modificacion FROM notas WHERE id_usuario = :id");
    $stmt->execute(['id'=> $id]);
    $notas =$stmt->fetchAll(PDO::FETCH_ASSOC);

     Helper::jsonOutputNotas(0,$notas?:[]);

}


//Función para borrar una nota del usuario 
function borrarNota($idNota,$id_usuario){
    $conexion = new Conexion();
    $pdo =$conexion->crearConexion();

    $stmt = $pdo->prepare("DELETE FROM notas WHERE id = :id AND id_usuario =:id_Us");
    $stmt->execute(['id'=> $idNota,'id_Us'=>$id_usuario]);
    Helper::jsonOutput(0,"La nota se ha borrado con éxito");
}


//Función para buscar una única nota
function buscarNota($notaId,$id_usuario){
    $conexion = new Conexion();
    $pdo =$conexion->crearConexion();
    $stmt = $pdo->prepare("SELECT * FROM notas WHERE id = :id AND id_usuario = :id_usuario");
    $stmt->execute(['id'=> $notaId,'id_usuario'=>$id_usuario]);
    $nota =$stmt->fetch(PDO::FETCH_ASSOC);
     Helper::jsonOutputNotas(0,$nota ?: []);
}


//Función para actualizar una nota
function actualizarNota($titulo,$contenido,$idNota){
    $conexion = new Conexion();
    $pdo =$conexion->crearConexion();

    $stmt = $pdo->prepare("UPDATE notas SET titulo = :titulo, contenido = :contenido WHERE id =:idNota");
    $stmt->execute(['titulo' =>$titulo, 'contenido' =>$contenido,'idNota'=>$idNota]);
    Helper::jsonOutput(0,"La nota se ha actualizado con éxito");

}


//Diferencia según el dato que obtiene el post que función tiene que llamar
if($_SERVER['REQUEST_METHOD']==='POST'){

    if(isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['idNota'])){
        var_dump("estoy dentro del if de actualizar");
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $idNota = $_POST['idNota'];  
        actualizarNota($titulo,$contenido,$idNota);
    }
    elseif(isset($_POST['titulo']) && isset($_POST['contenido'])){
        var_dump("estoy dentro del if de crearNota");
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];    
        crearNota($titulo,$contenido,$id_usuario);
    }

    elseif(isset($_POST['idNota'])){
        $idNota = $_POST['idNota'];
        borrarNota($idNota,$id_usuario);
    }
    elseif(isset($_POST['notaId'])){
        $notaId = $_POST['notaId'];
        buscarNota($notaId,$id_usuario);
    }
   
   
}
elseif($_SERVER['REQUEST_METHOD']==='GET'){
    mostrarNotas($id_usuario);
}



