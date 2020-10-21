<?php
require("../controller/ControllerTarefa.php");
require("../controller/ControllerJWT.php");

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$controller = new ControllerTarefa();
$token = new ControllerJWT();


/** Se houver o token na solicitação e o mesmo for válido,
    haverá a permissão para visualizar, cadastrar, alterar e deletar uma tarefa,
    caso contrário não poderá realizar nenhuma ação
 **/
$usuarioDados = [];
if($token->validation(apache_request_headers())){
    $permissao = true;
    $usuarioDados = $token->decode(strrev($_COOKIE["_validador"]));
}else{
    $permissao = false;
}

$data = array();

switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        parse_str(file_get_contents("php://input"), $_POST);
        if (isset($_POST["titulo"])
            && isset($_POST["descricao"])
            && isset($_POST["dataInicio"])
            && isset($_POST["dataFim"])
            && $permissao) {

            $apiDados = [
                "titulo" => $_POST["titulo"],
                "descricao" => $_POST["descricao"],
                "dataInicio" => $_POST["dataInicio"],
                "dataFim" => $_POST["dataFim"],
                "codUsuario" => $usuarioDados->sub
            ];

            if($controller->inserirTarefa($apiDados)){
                $data["success"] = true;
                $data["message"] = "A tarefa foi registrada com sucesso!";
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível registrar a tarefa!";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    case "GET":
        if(isset($_GET['cod']) && $permissao) {
            $apiDados = ["cod" => $_GET['cod']];
            $dataUser = $controller->selecionarTarefa($apiDados);

            if($dataUser != false){
                $data["success"] = true;
                $data["tarefa"] = $dataUser;
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível listar a tarefa!";
            }

        }elseif (isset($usuarioDados->sub) && $permissao) {
            $apiDados = ["codUsuario" => $usuarioDados->sub];
            $dataUser = $controller->selecionarTarefas($apiDados);

            if($dataUser["success"]){
                $data["success"] = true;
                $data["tarefas"] = $dataUser["message"];
            }else{
                $data["success"] = $dataUser["success"];
                $data["message"] = $dataUser["message"];
            }
        }else{
            $data["success"] = false;
            $data["message"] = "Não foi possível listar a tarefa!";
        }
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT["cod"])
            && isset($_PUT["titulo"])
            && isset($_PUT["descricao"])
            && isset($_PUT["dataInicio"])
            && isset($_PUT["dataFim"])
            && $permissao) {

            if (isset($_PUT["status"]))
                $status = '1';
            else
                $status = '0';

            $apiDados = [
                "cod" => $_PUT["cod"],
                "titulo" => $_PUT["titulo"],
                "descricao" => $_PUT["descricao"],
                "dataInicio" => $_PUT["dataInicio"],
                "dataFim" => $_PUT["dataFim"],
                "status" => $status
            ];

            if($controller->alterarTarefa($apiDados)){
                $data["success"] = true;
                $data["message"] = "A tarefa foi alterada com sucesso!";
                $data["apiDados"] = $apiDados;
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível alterar a tarefa!";
            }
        } else {
            $data["success"] = false;
            $data["message"] = "Parâmetros incompletos!";
        }
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE["cod"]) && $permissao) {
            $apiDados = ["cod" => $_DELETE['cod']];
            if($controller->deletarTarefa($apiDados)){
                $data["success"] = true;
                $data["message"] = "A tarefa foi deletada com sucesso!";
            }else{
                $data["success"] = false;
                $data["message"] = "Não foi possível deletar a tarefa!";
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