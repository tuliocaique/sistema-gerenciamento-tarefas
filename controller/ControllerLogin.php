<?php
require("../model/ModelUsuario.php");
require("../controller/ControllerJWT.php");
require("../dao/LoginDAO.php");
require_once __DIR__ . '/../lib/vendor/autoload.php';
use \Firebase\JWT\JWT;

class ControllerLogin
{
    private ModelUsuario $usuario;
    private LoginDAO $loginDAO;
    private ControllerJWT $jwtController;

    /**
     * ControllerLogin constructor.
     */
    public function __construct() {
        $this->usuario = new ModelUsuario();
        $this->jwtController = new ControllerJWT();
        $this->loginDAO = new LoginDAO();
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function logar($apiContent) {
        $this->usuario->setEmail($apiContent['email']);

        //checa se existe usuário com email informado
        $retornoUsuario = $this->loginDAO->checarCredenciais($this->usuario);
        if($retornoUsuario){

            //checa se a senha e a hash armazenada no bd dão match
            if(password_verify($apiContent['senha'], $retornoUsuario['senha'])) {

                //gera um token
                return $this->jwtController->encode($retornoUsuario['cod']);
            }else{
                return false;
            }
        }
        return false;
    }
}