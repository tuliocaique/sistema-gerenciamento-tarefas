<?php
require("../model/Database.php");

/**
 * Class UsuarioDAO
 */
class UsuarioDAO
{
    private PDO $db;

    /**
     * UsuarioDAO constructor.
     */
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool
     */
    public function inserir(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("INSERT INTO `usuario`(`cod`, `email`, `senha`) VALUES(:cod, :email, :senha)");
            $prepare->bindValue(':cod', $usuario->getCod());
            $prepare->bindValue(':email', $usuario->getEmail());
            $prepare->bindValue(':senha', $usuario->getSenha());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool
     */
    public function alterarEmail(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("UPDATE `usuario` SET `email` = :email WHERE `cod` = :cod");
            $prepare->bindValue(':email', $usuario->getEmail());
            $prepare->bindValue(':cod', $usuario->getCod());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool
     */
    public function alterarSenha(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("UPDATE `usuario` SET `senha` = :senha WHERE `cod` = :cod");
            $prepare->bindValue(':senha', $usuario->getSenha());
            $prepare->bindValue(':cod', $usuario->getCod());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool
     */
    public function deletar(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("DELETE FROM `usuario` WHERE `cod` = :cod");
            $prepare->bindValue(':cod', $usuario->getCod());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool|mixed
     */
    public function selecionar(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("SELECT * FROM `usuario` WHERE `cod` = :cod OR `email` = :email");
            $prepare->bindValue(':cod', $usuario->getCod());
            $prepare->bindValue(':email', $usuario->getEmail());
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool|mixed
     */
    public function selecionarPorEmail(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("SELECT `cod`, `email` FROM `usuario` WHERE `email` = :email");
            $prepare->bindValue(':email', $usuario->getEmail());
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelUsuario $usuario
     * @return bool|mixed
     */
    public function selecionarPorCod(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("SELECT `cod`, `email` FROM `usuario` WHERE `cod` = :cod");
            $prepare->bindValue(':cod', $usuario->getCod());
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }
}