<?php

namespace App\AtividadeFisica\Model;

class AtividadeFisica
{
    private $idAtividadeFisica;
    private $descricao;
    private $ativa;

    /**
     * @param $idAtividadeFisica
     * @param $descricao
     * @param $ativa
     */
    public function __construct($idAtividadeFisica, $descricao, $ativa)
    {
        $this->idAtividadeFisica = $idAtividadeFisica;
        $this->descricao = $descricao;
        $this->ativa = $ativa;
    }


    /**
     * @return mixed
     */
    public function getIdAtividadeFisica()
    {
        return $this->idAtividadeFisica;
    }

    /**
     * @param mixed $idAtividadeFisica
     */
    public function setIdAtividadeFisica($idAtividadeFisica): void
    {
        $this->idAtividadeFisica = $idAtividadeFisica;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getAtiva()
    {
        return $this->ativa;
    }

    /**
     * @param mixed $ativa
     */
    public function setAtiva($ativa): void
    {
        $this->ativa = $ativa;
    }

    public function obterTodasAtividadesFisicas(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.atividadefisica");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function cadastrar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.atividadefisica (descricao,ativa) VALUES(:descricao,'1')");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizar(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.atividadefisica SET descricao = :descricao, ativa = :ativa WHERE idAtividadeFisica = :idAtividadeFisica");
        $stmt->bindValue(":idAtividadeFisica",$this->getIdAtividadeFisica(),\PDO::PARAM_INT);
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":ativa",$this->getAtiva(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function verificarCadastrado(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idAtividadeFisica FROM feminina.atividadefisica WHERE descricao = :descricao");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function deletar(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.atividadefisica WHERE idAtividadeFisica = :idAtividadeFisica");
        $stmt->bindValue(":idAtividadeFisica",$this->getIdAtividadeFisica(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

}