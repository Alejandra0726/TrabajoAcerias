<?php

class Conexion 
{
    private $host = "localhost";
    private $db = "BDAcerias";
    private $user = "root";
    private $password = "";

    public function conectar(){
        $dns = "mysql:host={$this->host};dbname={$this->baseDatos};charset=utf8mb4";

        return new PDO($dsn, $this->user, $this->password,[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
    


    }
}