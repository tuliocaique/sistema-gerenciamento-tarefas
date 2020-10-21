<?php
require("../controller/ControllerLogin.php");

ini_set('session.cookie_httponly', 1);
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Set-Cookie: name=_uid; httpOnly");
header("Set-Cookie: name=_uid_new; httpOnly");

$data = array();
$controller = new ControllerLogin();

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        if (isset($_POST["email"]) && isset($_POST["senha"])) {
            $apiDados = ["email" => $_POST["email"], "senha" => $_POST["senha"]];
            $token = $controller->logar($apiDados);

            if($token != false){
                if(headers_sent()){
                    throw new Exception('Cannot set cookie, headers already sent');
                }else {
                    date_default_timezone_set('America/Sao_Paulo');
                    setcookie("_validador", strrev($token), time() + 3600, "/") ;
                    $data["success"] = true;
                    $data["message"] = "Login realizado com sucesso!";
                }
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível realizar o login!";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    case "DELETE":
        if (isset($_COOKIE["_validador"])) {
            unset($_COOKIE["_validador"]);

            date_default_timezone_set('America/Sao_Paulo');
            setcookie("_validador", null, -1);

            $data["success"] = true;
            $data["message"] = "Logout efetuado com sucesso!";
        } else {
            $data["success"] = false;
            $data["message"] = "Houve um erro!";
        }
        break;

    default:
        $data["success"] = false;
        $data["message"] = "Parâmetros incompletos!";
        break;
}
echo json_encode($data, JSON_PRETTY_PRINT);