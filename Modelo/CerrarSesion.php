<?php
//Manejar la respuesta en un JSON 
header ("Content-Type: application/json; charset=utf-8") 

 if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    //saltar a cathch y mostrar el mensaje de error
    throw new Exception("Método HTTP no permitido");

    }

    session_start(); // trae los datos q ya estan guardados de inicio de sesion
    $_SESSION=[];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); //destruye los datos de la sesion 

    echo json_decode([
        "success" => true,
    ]);