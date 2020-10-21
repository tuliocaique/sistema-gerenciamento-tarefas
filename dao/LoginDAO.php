<?php
require("../model/Database.php");

/**
 * Class LoginDAO
 */
class LoginDAO
{
    private PDO $db;

    /**
     * LoginDAO constructor.
     */
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }


    /**
     * @param ModelUsuario $usuario
     * @return bool|mixed
     */
    public function checarCredenciais(ModelUsuario $usuario){
        try {
            $prepare = $this->db->prepare("SELECT * FROM `usuario` WHERE `email` = :email");
            $prepare->bindValue(':email', $usuario->getEmail());
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }
}