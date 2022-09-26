<?php

namespace App\Contrato\Model;

class FormaPagamento
{
    private $idFormaPagamento;
    private $descricao;
    private $pagamentoAutomatico;

    /**
     * @param $idFormaPagamento
     * @param $descricao
     * @param $pagamentoAutomatico
     */
    public function __construct($idFormaPagamento, $descricao, $pagamentoAutomatico)
    {
        $this->idFormaPagamento = $idFormaPagamento;
        $this->descricao = $descricao;
        $this->pagamentoAutomatico = $pagamentoAutomatico;
    }

    /**
     * @return mixed
     */
    public function getIdFormaPagamento()
    {
        return $this->idFormaPagamento;
    }

    /**
     * @param mixed $idFormaPagamento
     */
    public function setIdFormaPagamento($idFormaPagamento): void
    {
        $this->idFormaPagamento = $idFormaPagamento;
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
    public function getPagamentoAutomatico()
    {
        return $this->pagamentoAutomatico;
    }

    /**
     * @param mixed $pagamentoAutomatico
     */
    public function setPagamentoAutomatico($pagamentoAutomatico): void
    {
        $this->pagamentoAutomatico = $pagamentoAutomatico;
    }

    public function obterFormaPagamentoPorId(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idFormaPagamento, descricao, pagamentoAutomatico FROM feminina.formapagamento WHERE idFormaPagamento = :idFormaPagamento");
        $stmt->bindValue(":idFormaPagamento",$this->getIdFormaPagamento(),\PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setIdFormaPagamento($dados['idFormaPagamento']);
            $this->setDescricao($dados['descricao']);
            $this->setPagamentoAutomatico($dados['pagamentoAutomatico']);
        }
    }

    public function obterTodasFormasPagamento(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.formapagamento");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}