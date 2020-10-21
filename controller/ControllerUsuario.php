<?php
require("../model/ModelUsuario.php");
require("../dao/UsuarioDAO.php");

class ControllerUsuario
{
    private ModelUsuario $usuario;
    private UsuarioDAO $usuarioDAO;

    /**
     * ControllerUsuario constructor.
     */
    public function __construct() {
        $this->usuario = new ModelUsuario();
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function inserirUsuario($apiContent) {
        $options = ['cost' => 12];

        $this->usuario->setEmail($apiContent['email']);
        $this->usuario->setSenha(password_hash($apiContent['senha'], PASSWORD_BCRYPT, $options));

        if($this->usuarioDAO->inserir($this->usuario)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function alterarUsuario($apiContent) {
        if(isset($apiContent['email']))
            return $this->alterarEmailUsuario($apiContent);
        elseif(isset($apiContent['senha']))
            return $this->alterarSenhaUsuario($apiContent);
        return false;
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function alterarEmailUsuario($apiContent) {
        $this->usuario->setCod($apiContent['cod']);

        $this->usuario->setEmail($apiContent['email']);
        if($this->usuarioDAO->alterarEmail($this->usuario)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function alterarSenhaUsuario($apiContent) {
        $options = ['cost' => 12];
        $this->usuario->setCod($apiContent['cod']);
        $this->usuario->setSenha(password_hash($apiContent['senha'], PASSWORD_BCRYPT, $options));

        if($this->usuarioDAO->alterarSenha($this->usuario)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function deletarUsuario($apiContent) {
        $this->usuario->setCod($apiContent['cod']);

        if($this->usuarioDAO->deletar($this->usuario)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool|mixed
     */
    public function selecionarUsuario($apiContent) {
        if(isset($apiContent['email']))
            return $this->selecionarUsuarioPorEmail($apiContent);
        elseif(isset($apiContent['cod']))
            return $this->selecionarUsuarioPorCod($apiContent);
        return false;
    }

    /**
     * @param $apiContent
     * @return bool|mixed
     */
    public function selecionarUsuarioPorEmail($apiContent) {
        $this->usuario->setEmail($apiContent['email']);
        return $this->usuarioDAO->selecionarPorEmail($this->usuario);
    }

    /**
     * @param $apiContent
     * @return bool|mixed
     */
    public function selecionarUsuarioPorCod($apiContent) {
        $this->usuario->setCod($apiContent['cod']);
        return $this->usuarioDAO->selecionarPorCod($this->usuario);
    }
}