<?php

class Conexion
{
    private $host = "localhost";
    private $db = "acerias";
    private $user = "root";
    private $password = "";

    public function conectar()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}