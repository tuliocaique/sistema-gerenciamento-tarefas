<?php
require("../controller/ControllerJWT.php");

ini_set('session.cookie_httponly', 1);
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Set-Cookie: name=_uid; httpOnly");
header("Set-Cookie: name=_uid_new; httpOnly");


$data = array();
$controller = new ControllerJWT();

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if(isset($_COOKIE["_validador"])) {
            //Pega o token atual que está armazenado e faz um parse para pegar o codUsuario
            $token = $controller->decode(strrev($_COOKIE["_validador"]));

            //Gera um novo token a partir do codUsuario e o armazena
            date_default_timezone_set('America/Sao_Paulo');
            setcookie("_validador", strrev($controller->encode($token->sub)), time()+3600, "/");

            $data["success"] = true;
            $data["refreshToken"] = strrev($_COOKIE["_validador"]);
        } else {
            $data["success"] = false;
            $data["message"] = "Permissão negada.";
            http_response_code(401);
        }
        break;

    default:
        $data["success"] = false;
        $data["message"] = "Parâmetros incompletos!";
        http_response_code(400);
        break;
}
echo json_encode($data, JSON_PRETTY_PRINT);