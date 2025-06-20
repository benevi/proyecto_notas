<?php

namespace ProyectoNotas;

use PDO;
use PDOException;



//Clase para crear la conexion a la base de datos 
class Conexion
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $dsn;
    protected $conexion;

    public function __construct()
    {
       $this->host = "localhost";
       $this->db = "tu_base_de_datos";
       $this->user = "tu_usuario";
       $this->pass = "tu_contraseña";
       $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
       $this->crearConexion();
    }

    public function crearConexion()
    {
        try {
            $this->conexion = new PDO($this->dsn, $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Error en la conexión: mensaje: " . $ex->getMessage());
        }
        return $this->conexion;
    }
}