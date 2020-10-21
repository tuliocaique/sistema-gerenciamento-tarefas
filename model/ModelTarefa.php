<?php


class ModelTarefa
{
    private string $cod;
    private string $titulo;
    private string $descricao;
    private string $dataInicio;
    private string $dataFim;
    private string $status;
    private string $codUsuario;

    /**
     * ModelTarefa constructor.
     */
    public function __construct()
    {
        $this->cod = uniqid();
    }

    /**
     * @return string
     */
    public function getCod(): string
    {
        return $this->cod;
    }

    /**
     * @param string $cod
     */
    public function setCod(string $cod): void
    {
        $this->cod = $cod;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return string
     */
    public function getDataInicio(): string
    {
        return $this->dataInicio;
    }

    /**
     * @param string $dataInicio
     */
    public function setDataInicio(string $dataInicio): void
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     * @return string
     */
    public function getDataFim(): string
    {
        return $this->dataFim;
    }

    /**
     * @param string $dataFim
     */
    public function setDataFim(string $dataFim): void
    {
        $this->dataFim = $dataFim;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCodUsuario(): string
    {
        return $this->codUsuario;
    }

    /**
     * @param string $codUsuario
     */
    public function setCodUsuario(string $codUsuario): void
    {
        $this->codUsuario = $codUsuario;
    }


}