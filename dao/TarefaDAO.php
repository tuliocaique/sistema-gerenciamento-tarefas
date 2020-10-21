<?php
require("../model/Database.php");

/**
 * Class TarefaDAO
 */
class TarefaDAO
{
    private PDO $db;

    /**
     * TarefaDAO constructor.
     */
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * @param ModelTarefa $tarefa
     * @return bool
     */
    public function inserir(ModelTarefa $tarefa){
        try {
            $prepare = $this->db->prepare("INSERT INTO `tarefa`(`cod`, `titulo`, `descricao`, `dataInicio`, `dataFim`, `status`, `codUsuario`) VALUES(:cod, :titulo, :descricao, :dataInicio, :dataFim, 1, :codUsuario)");
            $prepare->bindValue(':cod', $tarefa->getCod());
            $prepare->bindValue(':titulo', $tarefa->getTitulo());
            $prepare->bindValue(':descricao', $tarefa->getDescricao());
            $prepare->bindValue(':dataInicio', $tarefa->getDataInicio());
            $prepare->bindValue(':dataFim', $tarefa->getDataFim());
            $prepare->bindValue(':codUsuario', $tarefa->getCodUsuario());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelTarefa $tarefa
     * @return bool
     */
    public function alterar(ModelTarefa $tarefa){
        try {
            $prepare = $this->db->prepare("UPDATE `tarefa` SET `titulo` = :titulo, `descricao` = :descricao, `dataInicio` = :dataInicio, `dataFim` = :dataFim,`status` = :status WHERE `cod` = :cod");
            $prepare->bindValue(':titulo', $tarefa->getTitulo());
            $prepare->bindValue(':descricao', $tarefa->getDescricao());
            $prepare->bindValue(':dataInicio', $tarefa->getDataInicio());
            $prepare->bindValue(':dataFim', $tarefa->getDataFim());
            $prepare->bindValue(':status', $tarefa->getStatus());
            $prepare->bindValue(':cod', $tarefa->getCod());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }


    /**
     * @param ModelTarefa $tarefa
     * @return bool
     */
    public function deletar(ModelTarefa $tarefa){
        try {
            $prepare = $this->db->prepare("DELETE FROM `tarefa` WHERE `cod` = :cod");
            $prepare->bindValue(':cod', $tarefa->getCod());
            return $prepare->execute();
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param ModelTarefa $tarefa
     * @return bool|mixed
     */
    public function selecionarTarefas(ModelTarefa $tarefa){
        try {
            $prepare = $this->db->prepare("SELECT * FROM `listarTarefas` WHERE `codUsuario` = :codUsuario");
            $prepare->bindValue(':codUsuario', $tarefa->getCodUsuario());
            $prepare->execute();

            if($prepare->rowCount() > 0){
                $tarefas = array();
                while($resultado = $prepare->fetch(PDO::FETCH_ASSOC)){
                    array_push($tarefas, array("cod" => $resultado["cod"],
                        "titulo" => $resultado["titulo"],
                        "descricao" => $resultado["descricao"],
                        "dataInicio" => $resultado["dataInicio"],
                        "dataFim" => $resultado["dataFim"],
                        "status" => $resultado["status"]));
                }
                return array("cod" => 200, "success" => true, "message" => $tarefas);
            } else {
                return array("cod" => 400, "success" => false, "message" => "Não há nenhuma tarefa cadastrada.");
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return array("cod" => 400, "success" => false, "message" => "Houve um erro ao listar as tarefas.");
    }

    /**
     * @param ModelTarefa $tarefa
     * @return bool|mixed
     */
    public function selecionarTarefa(ModelTarefa $tarefa){
        try {
            $prepare = $this->db->prepare("SELECT * FROM `tarefa` WHERE `cod` = :cod");
            $prepare->bindValue(':cod', $tarefa->getCod());
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }
}