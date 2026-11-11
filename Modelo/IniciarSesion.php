<?php

session_start();  // Inicia la sesión para poder almacenar o traer información del usuario o traer una ya existente 

header("Content-Type: application/json; charset=UTF-8");

try{
    if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);

    //saltar a cathch y mostrar el mensaje de error
    throw new Exception("Método HTTP no permitido");
    }
    $datos = json_decode(file_get_contents('php://input'), true); //Lee el contenido de JavaScript 
    
    // Validar que los datos sean un array y que no haya errores en la decodificación JSON
    if(!is_array($datos) || json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);    
    throw new Exception("Datos inválidos");
    }

    $email = $datos ['email'] ?? ""; //si no hay nada en el campo queda la cadena vacia. 
    $password = $datos ['password'] ?? "";

    if(!is_string($email) || !is_string($password) || $email === "" || $password === "") {
        http_response_code(400);
        throw new Exception("Email o contraseña son inválidos");
    }
    require_once __DIR__ . '/../Config/conexion.php';
    $conexion = (new Conexion()) -> conectar();

    $consulta = $conexion-> prepare("SELECT * FROM asociados WHERE email = :email");
    $consulta->execute([':email' => $email]);
    $asociado =$consulta->fetch();

    if(!$asociado || !password_verify($password,$asociado['password']) || empty($asociado['password'])){
        http_response_code(401);
        throw new Exception("Email o contraseña incorrectos");  
    }
    // Almacenar información del usuario en la sesión
    $_SESSION["rol"] = strtolower($asociado['rol']); //convertir a minusculas para evitar problemas de comparacion
    $_SESSION["documento"] = $asociado['documento'];

    echo json_encode([
        "success" => true,
        "rol" => $_SESSION["rol"],
        "nombre" => $asociado["nombres"] . " " . $asociado["apellidos"],
    ]);
}Catch(PDOException $e){
    $errorMessage = "Error: " . $e->getMessage();
    echo json_encode([
        "success" => false,
         "mensaje" => $errorMessage
        ]);
}Catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "mensaje" => $e->getMessage()
    ]);


}