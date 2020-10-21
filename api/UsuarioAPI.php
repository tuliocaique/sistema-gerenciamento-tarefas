<?php
require("../controller/ControllerUsuario.php");
require("../controller/ControllerJWT.php");

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$controller = new ControllerUsuario();
$token = new ControllerJWT();


/** Se houver o token na solicitação e o mesmo for válido,
    haverá a permissão para visualizar, alterar e deletar o usuário,
    caso contrário só poderá cadastrar um usuário
 **/
if($token->validation(apache_request_headers())) {
    $permissao = true;
    $usuarioDados = $token->decode(strrev($_COOKIE["_validador"]));
}else {
    $permissao = false;
}

$data = array();

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        if (isset($_POST["email"]) && isset($_POST["senha"])) {
            $apiDados = ["email" => $_POST["email"], "senha" => $_POST["senha"]];

            if($controller->inserirUsuario($apiDados)){
                $data["success"] = true;
                $data["message"] = "O usuário foi registrado com sucesso!";
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível registrar o usuário!";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    case "GET":
        if (isset($usuarioDados->sub) && $permissao) {
            $apiDados = ["cod" => $usuarioDados->sub];
            $dataUser = $controller->selecionarUsuario($apiDados);
            if($dataUser != false){
                $data["success"] = true;
                $data["usuario"] = $dataUser;
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível encontrar o usuário!";
            }
        }
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($usuarioDados->sub) && $permissao) {
            if(isset($_PUT['email']))
                $apiDados = ["cod" => $usuarioDados->sub, "email" => $_PUT['email']];
            elseif (isset($_PUT['senha']))
                $apiDados = ["cod" => $usuarioDados->sub, "senha" => $_PUT['senha']];

            $retorno = $controller->alterarUsuario($apiDados);
            if($retorno){
                $data["success"] = true;
                $data["message"] = "A alteração foi alterado com sucesso!";
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível realizar a alteração!";
                $data["retorno"] = $retorno;
                $data["apiDados"] = $apiDados;
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($usuarioDados->sub) && $permissao) {
            $apiDados = ["cod" => $usuarioDados->sub];

            if($controller->deletarUsuario($apiDados)){
                $data["success"] = true;
                $data["message"] = "O usuário foi deletado com sucesso!";
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível deletar o usuário!";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    default:
        $data["success"] = false;
        $data["message"] = "Parâmetros incompletos!";
        break;
}

echo json_encode($data, JSON_PRETTY_PRINT);