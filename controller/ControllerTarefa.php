<?php
require("../model/ModelTarefa.php");
require("../dao/TarefaDAO.php");

class ControllerTarefa
{
    private ModelTarefa $tarefa;
    private TarefaDAO $tarefaDAO;

    /**
     * ControllerTarefa constructor.
     */
    public function __construct() {
        $this->tarefa = new ModelTarefa();
        $this->tarefaDAO = new TarefaDAO();
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function inserirTarefa($apiContent) {
        $this->tarefa->setTitulo($apiContent['titulo']);
        $this->tarefa->setDescricao($apiContent['descricao']);
        $this->tarefa->setDataInicio($apiContent['dataInicio']);
        $this->tarefa->setDataFim($apiContent['dataFim']);
        $this->tarefa->setCodUsuario($apiContent['codUsuario']);

        if($this->tarefaDAO->inserir($this->tarefa)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool
     */
    public function alterarTarefa($apiContent) {
        $this->tarefa->setCod($apiContent['cod']);
        $this->tarefa->setTitulo($apiContent['titulo']);
        $this->tarefa->setDescricao($apiContent['descricao']);
        $this->tarefa->setDataInicio($apiContent['dataInicio']);
        $this->tarefa->setDataFim($apiContent['dataFim']);
        $this->tarefa->setStatus($apiContent['status']);

        return $this->tarefaDAO->alterar($this->tarefa);
    }


    /**
     * @param $apiContent
     * @return bool
     */
    public function deletarTarefa($apiContent) {
        $this->tarefa->setCod($apiContent['cod']);

        if($this->tarefaDAO->deletar($this->tarefa)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $apiContent
     * @return bool|mixed
     */
    public function selecionarTarefas($apiContent) {
        $this->tarefa->setCodUsuario($apiContent['codUsuario']);
        return $this->tarefaDAO->selecionarTarefas($this->tarefa);
    }

    /**
     * @param $apiContent
     * @return bool|mixed
     */
    public function selecionarTarefa($apiContent) {
        $this->tarefa->setCod($apiContent['cod']);
        return $this->tarefaDAO->selecionarTarefa($this->tarefa);
    }
}