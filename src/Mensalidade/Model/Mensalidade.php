<?php

namespace App\Mensalidade\Model;

use App\Contrato\Model\Contrato;
use App\Contrato\Model\FormaPagamento;
use App\Utils\ObjectHelper;

class Mensalidade
{
    private $idMensalidade;
    private $contrato;
    private $formaPagamento;
    private $valor;
    private $dataMensalidade;
    private $dataPagamento;
    private $mensalidadeCancelada;

    /**
     * @param $idMensalidade
     * @param $matricula
     * @param $formaPagamento
     * @param $valor
     * @param $dataMensalidade
     * @param $dataPagamento
     */
    public function __construct($idMensalidade, $contrato,$formaPagamento, $valor, $dataMensalidade, $dataPagamento,$mensalidadeCancelada)
    {
        $this->idMensalidade = $idMensalidade;
        $this->contrato = $contrato;
        $this->formaPagamento = $formaPagamento;
        $this->valor = $valor;
        $this->dataMensalidade = $dataMensalidade;
        $this->dataPagamento = $dataPagamento;
        $this->mensalidadeCancelada = $mensalidadeCancelada;
    }

    /**
     * @return mixed
     */
    public function getMensalidadeCancelada()
    {
        return $this->mensalidadeCancelada;
    }

    /**
     * @param mixed $mensalidadeCancelada
     */
    public function setMensalidadeCancelada($mensalidadeCancelada): void
    {
        $this->mensalidadeCancelada = $mensalidadeCancelada;
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
    public function getContrato()
    {
        return $this->contrato;
    }

    /**
     * @param mixed $contrato
     */
    public function setContrato($contrato): void
    {
        $this->contrato = $contrato;
    }

    /**
     * @return mixed
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * @param mixed $formaPagamento
     */
    public function setFormaPagamento($formaPagamento): void
    {
        $this->formaPagamento = $formaPagamento;
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
    public function getDataMensalidade()
    {
        return $this->dataMensalidade;
    }

    /**
     * @param mixed $dataMensalidade
     */
    public function setDataMensalidade($dataMensalidade): void
    {
        $this->dataMensalidade = $dataMensalidade;
    }

    /**
     * @return mixed
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * @param mixed $dataPagamento
     */
    public function setDataPagamento($dataPagamento): void
    {
        $this->dataPagamento = $dataPagamento;
    }


    public function gravar(?\PDO $conn)
    {
        $ret = false;
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.mensalidade (idContrato,idFormaPagamento, valor, dataMensalidade,dataPagamento) VALUES (:idContrato,:idFormaPagamento,:valor,:dataMensalidade,:dataPagamento)");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->bindValue(":idFormaPagamento",$this->getFormaPagamento()->getIdFormaPagamento(),\PDO::PARAM_INT);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataMensalidade",$this->getDataMensalidade(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataPagamento",$this->getDataPagamento(),\PDO::PARAM_STR);
            if($stmt->execute())
            {
                $ret = true;
                $this->setIdMensalidade($conn->lastInsertId());
            }
        }catch (\PDOException $e)
        {

        }
        return $ret;
    }

    public function deletarPorContrato(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.mensalidade WHERE idContrato = :idContrato");
        $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterTodasMensalidadesPorContrato(?\PDO $conn)
    {
        $mensalidades = [];
        try{
            $stmt = $conn->prepare("SELECT idMensalidade,idContrato,idFormaPagamento,valor,dataMensalidade,dataPagamento,mensalidadeCancelada FROM feminina.mensalidade WHERE idContrato = :idContrato");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $formasPagamento = new FormaPagamento(null,null,null);
            $formasPagamento = $formasPagamento->obterTodasFormasPagamento($conn);
            foreach ($dados as $dado)
            {
                $formaPagamento = null;
                if(!empty($dado['idFormaPagamento']))
                {
                    foreach ($formasPagamento as $fp)
                    {
                        if($fp['idFormaPagamento'] == $dado['idFormaPagamento'])
                        {
                            $formaPagamento = $fp;
                            break;
                        }
                    }
                }
                $contrato = $this->getContrato();
                $mensalidades[] = new Mensalidade($dado['idMensalidade'],ObjectHelper::dismount($contrato),ObjectHelper::dismount($formaPagamento),$dado['valor'],$dado['dataMensalidade'],$dado['dataPagamento'],$dado['mensalidadeCancelada']);
            }
        }catch (\PDOException $e)
        {

        }
        return $mensalidades;
    }

    public function obterMensalidadePorId(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idMensalidade, idContrato, idFormaPagamento, valor, dataMensalidade, dataPagamento,mensalidadeCancelada FROM feminina.mensalidade WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($dados))
            {
                $contrato = new Contrato($dados['idContrato'],null,null,null,null,null,null,null,null,null);
                $contrato->obterContratoById($conn);
                $this->setContrato($contrato);
                $formaPagamento = new FormaPagamento($dados['idFormaPagamento'],null,null);
                $formaPagamento->obterFormaPagamentoPorId($conn);
                $this->setFormaPagamento($formaPagamento);
                $this->setValor($dados['valor']);
                $this->setDataMensalidade($dados['dataMensalidade']);
                $this->setDataPagamento($dados['dataPagamento']);
                $this->setMensalidadeCancelada($dados['mensalidadeCancelada']);
            }else{
                $this->setIdMensalidade(null);
            }
        }catch (\PDOException $e)
        {

        }
    }

    public function efetuarPagamento(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.mensalidade SET dataPagamento = :dataPagamento, idFormaPagamento = :idFormaPagamento WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":dataPagamento",date("Y-m-d"),\PDO::PARAM_STR);
            $stmt->bindValue(":idFormaPagamento",$this->getFormaPagamento()->getIdFormaPagamento(),\PDO::PARAM_INT);
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);

        }catch (\PDOException $e)
        {

        }
        return $stmt->execute();
    }

    public function cancelar(?\PDO $conn)
    {
        $retorno = false;
        try{

            $stmt = $conn->prepare("SELECT idMensalidade, idContrato, idFormaPagamento, valor, dataMensalidade, dataPagamento,mensalidadeCancelada FROM feminina.mensalidade WHERE idContrato = :idContrato AND dataPagamento is null");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if(!empty($dados) && is_array($dados) && count($dados) > 0)
            {
                $mensalidadePaga = false;
                $mensalidadesCanceladas = [];
                foreach ($dados as $key => $dado)
                {
                    if($key == 0)
                    {
                        $stmt = $conn->prepare("UPDATE feminina.mensalidade SET dataPagamento = CURDATE() WHERE idMensalidade = :idMensalidade");
                        $stmt->bindValue(":idMensalidade",$dado['idMensalidade'],\PDO::PARAM_INT);
                        $mensalidadePaga = $stmt->execute();
                    }else{
                        $stmt = $conn->prepare("UPDATE feminina.mensalidade SET mensalidadeCancelada = 1 WHERE idMensalidade = :idMensalidade");
                        $stmt->bindValue(":idMensalidade",$dado['idMensalidade'],\PDO::PARAM_INT);
                        $mensalidadesCanceladas[] = $stmt->execute();
                    }
                }
                if(!in_array(false,$mensalidadesCanceladas) && $mensalidadePaga)
                {
                    $retorno = true;
                }
            }

        }catch (\PDOException $e)
        {

        }
        return $retorno;
    }

    public function estornar(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.mensalidade SET dataPagamento = :dataPagamento WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":idMensalidade",$this->getIdMensalidade(),\PDO::PARAM_INT);
            $stmt->bindValue(":dataPagamento",null,\PDO::PARAM_NULL);
            return $stmt->execute();
        }catch (\PDOException $e)
        {

        }
    }

    public function verificarMensalidadesAnterioresNaoPagas(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idMensalidade, idContrato, idFormaPagamento, valor, dataMensalidade, dataPagamento, mensalidadeCancelada FROM feminina.mensalidade WHERE idContrato = :idContrato AND dataPagamento is NULL and dataMensalidade < :dataMensalidade");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->bindValue(":dataMensalidade",$this->getDataMensalidade(),\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }
}