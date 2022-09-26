<?php

namespace App\Receita\Model;

class Receita
{
    private $idReceita;
    private $origem;
    private $data;
    private $valor;
    private $idMensalidade;
    private $idAgendamentoAvaliacaoFisica;

    /**
     * @param $idReceita
     * @param $origem
     * @param $data
     * @param $valor
     * @param $idMensalidade
     * @param $idAgendamentoAvaliacaoFisica
     */
    public function __construct($idReceita, $origem, $data, $valor, $idMensalidade, $idAgendamentoAvaliacaoFisica)
    {
        $this->idReceita = $idReceita;
        $this->origem = $origem;
        $this->data = $data;
        $this->valor = $valor;
        $this->idMensalidade = $idMensalidade;
        $this->idAgendamentoAvaliacaoFisica = $idAgendamentoAvaliacaoFisica;
    }

    /**
     * @return mixed
     */
    public function getIdReceita()
    {
        return $this->idReceita;
    }

    /**
     * @param mixed $idReceita
     */
    public function setIdReceita($idReceita): void
    {
        $this->idReceita = $idReceita;
    }

    /**
     * @return mixed
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param mixed $origem
     */
    public function setOrigem($origem): void
    {
        $this->origem = $origem;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getIdMensalidade()
    {
        return $this->idMensalidade;
    }

    /**
     * @param mixed $idMensalidade
     */
    public function setIdMensalidade($idMensalidade): void
    {
        $this->idMensalidade = $idMensalidade;
    }

    /**
     * @return mixed
     */
    public function getIdAgendamentoAvaliacaoFisica()
    {
        return $this->idAgendamentoAvaliacaoFisica;
    }

    /**
     * @param mixed $idAgendamentoAvaliacaoFisica
     */
    public function setIdAgendamentoAvaliacaoFisica($idAgendamentoAvaliacaoFisica): void
    {
        $this->idAgendamentoAvaliacaoFisica = $idAgendamentoAvaliacaoFisica;
    }

    public function gerarReceitaAvaliacaoFisica(?\PDO $conn)
    {
        try {
            $stmt = $conn->prepare("INSERT INTO feminina.receita (origem, data, valor, idMensalidade, idAgendamentoAvaliacaoFisica) VALUES (:origem, :data, :valor, :idMensalidade, :idAgendamentoAvaliacaoFisica)");
            $stmt->bindValue(":origem",$this->getOrigem(),\PDO::PARAM_STR);
            $stmt->bindValue(":data",$this->getData(),\PDO::PARAM_STR);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function gerarReceitaPagamentoMensalidade(?\PDO $conn)
    {
        try {
            $stmt = $conn->prepare("INSERT INTO feminina.receita (origem, data, valor, idMensalidade, idAgendamentoAvaliacaoFisica) VALUES (:origem, :data, :valor, :idMensalidade, :idAgendamentoAvaliacaoFisica)");
            $stmt->bindValue(":origem",$this->getOrigem(),\PDO::PARAM_STR);
            $stmt->bindValue(":data",$this->getData(),\PDO::PARAM_STR);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }


    public function deletarByMensalidade(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("DELETE FROM feminina.receita WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function deletarByAgendamentoAvaliacaoFisica(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("DELETE FROM feminina.receita WHERE idAgendamentoAvaliacaoFisica = :idAgendamentoAvaliacaoFisica");
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function atualizarByAgendamentoAvaliacao(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.receita SET data = :data, valor = :valor WHERE idAgendamentoAvaliacaoFisica = :idAgendamentoAvaliacaoFisica");
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            $stmt->bindValue(":data",$this->getData(),\PDO::PARAM_STR);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

}