<?php

namespace App\Contrato\Model;

use App\Aluno\Model\Aluno;
use App\Mensalidade\Model\Mensalidade;
use App\Planos\Model\Plano;
use App\Utils\ObjectHelper;

class Contrato
{
    private $idContrato;
    private $plano;
    private $aluno;
    private $formaPagamento;
    private $dataInicio;
    private $dataFim;
    private $dataContrato;
    private $dataCancelamento;
    private $valor;
    private $diaPagamento;

    /**
     * @param $idContrato
     * @param $plano
     * @param $aluno
     * @param $formaPagamento
     * @param $dataInicio
     * @param $dataFim
     * @param $dataContrato
     * @param $dataCancelamento
     * @param $valor
     * @param $diaPagamento
     */
    public function __construct($idContrato, $plano, $aluno, $formaPagamento, $dataInicio, $dataFim, $dataContrato, $dataCancelamento, $valor, $diaPagamento)
    {
        $this->idContrato = $idContrato;
        $this->plano = $plano;
        $this->aluno = $aluno;
        $this->formaPagamento = $formaPagamento;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->dataContrato = $dataContrato;
        $this->dataCancelamento = $dataCancelamento;
        $this->valor = $valor;
        $this->diaPagamento = $diaPagamento;
    }

    /**
     * @return mixed
     */
    public function getIdContrato()
    {
        return $this->idContrato;
    }

    /**
     * @param mixed $idContrato
     */
    public function setIdContrato($idContrato): void
    {
        $this->idContrato = $idContrato;
    }

    /**
     * @return mixed
     */
    public function getPlano()
    {
        return $this->plano;
    }

    /**
     * @param mixed $plano
     */
    public function setPlano($plano): void
    {
        $this->plano = $plano;
    }

    /**
     * @return mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param mixed $aluno
     */
    public function setAluno($aluno): void
    {
        $this->aluno = $aluno;
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
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio): void
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim): void
    {
        $this->dataFim = $dataFim;
    }

    /**
     * @return mixed
     */
    public function getDataContrato()
    {
        return $this->dataContrato;
    }

    /**
     * @param mixed $dataContrato
     */
    public function setDataContrato($dataContrato): void
    {
        $this->dataContrato = $dataContrato;
    }

    /**
     * @return mixed
     */
    public function getDataCancelamento()
    {
        return $this->dataCancelamento;
    }

    /**
     * @param mixed $dataCancelamento
     */
    public function setDataCancelamento($dataCancelamento): void
    {
        $this->dataCancelamento = $dataCancelamento;
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
    public function getDiaPagamento()
    {
        return $this->diaPagamento;
    }

    /**
     * @param mixed $diaPagamento
     */
    public function setDiaPagamento($diaPagamento): void
    {
        $this->diaPagamento = $diaPagamento;
    }


    public function gravar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.contrato (idPlano, idAluno,idFormaPagamento, dataInicio, dataFim, dataContrato, dataCancelamento, valor, diaPagamento) VALUES (:idPlano, :idAluno,:idFormaPagamento, :dataInicio, :dataFim, :dataContrato, :dataCancelamento, :valor, :diaPagamento)");
        $stmt->bindValue(":idPlano",$this->getPlano()->getIdPlano(),\PDO::PARAM_INT);
        $stmt->bindValue(":idAluno",$this->getAluno()->getIdAluno(),\PDO::PARAM_INT);
        $stmt->bindValue(":idFormaPagamento",$this->getFormaPagamento()->getIdFormaPagamento(),\PDO::PARAM_INT);
        $stmt->bindValue(":dataInicio",$this->getDataInicio(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataFim",$this->getDataFim(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataContrato",$this->getDataContrato(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataCancelamento",$this->getDataCancelamento(),\PDO::PARAM_STR);
        $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
        $stmt->bindValue(":diaPagamento",$this->getDiaPagamento(),\PDO::PARAM_INT);
        if($stmt->execute())
            $this->setIdContrato($conn->lastInsertId());
        return $this->getIdContrato();
    }

    public function obterTodosContratos(?\PDO $conn,$atraso)
    {
        $sql = "SELECT ct.idContrato,ct.idPlano as plano,ct.idAluno as aluno,ct.idFormaPagamento as formaPagamento,ct.dataInicio,ct.dataFim,ct.dataContrato,ct.dataCancelamento,ct.valor,ct.diaPagamento FROM feminina.contrato ct";
        if($atraso)
        {
            $sql .= " JOIN feminina.mensalidade mens ON (mens.idContrato = ct.idContrato)
                        JOIN feminina.mensalidadeatraso ma ON (ma.idMensalidade = mens.idMensalidade)
                        GROUP BY ct.idContrato";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $contratos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(is_array($contratos))
        {
            foreach ($contratos as $key => $contrato)
            {
                $plano = new Plano($contrato['plano'],null,null,null,null,null);
                $plano->obterPlanoPorId($conn);

                $aluno = new Aluno($contrato['aluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $aluno->obterAlunoPorId($conn);
                $formaPagamento = new FormaPagamento($contrato['formaPagamento'],null,null);
                $formaPagamento->obterFormaPagamentoPorId($conn);
//                $mensalidade = new Mensalidade(null,$contrato,$formaPagamento,null,null,null);
//                $mensalidades = $mensalidade->obterTodasMensalidadesPorContrato($conn);
                $contratos[$key]['plano'] = ObjectHelper::dismount($plano);
                $contratos[$key]['plano']['atividadesFisicas'] = $plano->obterAtividadesFisicas($conn);
                $contratos[$key]['aluno'] = ObjectHelper::dismount($aluno);
//                $contratos[$key]['mensalidades'] = ObjectHelper::dismount($mensalidades);
                $contratos[$key]['formaPagamento'] = ObjectHelper::dismount($formaPagamento);
            }
        }
        return $contratos;
    }

    public function obterContratoById(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idContrato,idPlano,idAluno,idFormaPagamento,dataInicio,dataFim,dataContrato,dataCancelamento,valor,diaPagamento FROM feminina.contrato WHERE idContrato = :idContrato");
        $stmt->bindValue(":idContrato",$this->getIdContrato(),\PDO::PARAM_INT);
        $stmt->execute();
        $contrato = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($contrato))
        {
            $plano = new Plano($contrato['idPlano'],null,null,null,null,null);
            $plano->obterPlanoPorId($conn);
            $this->setPlano($plano);
            $aluno = new Aluno($contrato['idAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $aluno->obterAlunoPorId($conn);
            $this->setAluno($aluno);
            $formaPagamento = new FormaPagamento($contrato['idFormaPagamento'],null,null);
            $formaPagamento->obterFormaPagamentoPorId($conn);
            $this->setFormaPagamento($formaPagamento);
            $this->setDataInicio($contrato['dataInicio']);
            $this->setDataFim($contrato['dataFim']);
            $this->setDataContrato($contrato['dataContrato']);
            $this->setDataCancelamento($contrato['dataCancelamento']);
            $this->setValor($contrato['valor']);
            $this->setDiaPagamento($contrato['diaPagamento']);
        }
        else{
            $this->setIdContrato(null);
        }
    }

    public function deletar(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.contrato WHERE idContrato = :idContrato");
        $stmt->bindValue(":idContrato",$this->getIdContrato(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterContratosPorAluno(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.contrato WHERE idAluno = :idAluno AND dataCancelamento is null");
        $stmt->bindValue(":idAluno",$this->aluno->getIdAluno(),\PDO::PARAM_INT);
        $stmt->execute();
        $contrato = $stmt->fetch(\PDO::FETCH_ASSOC);
        $retorno = false;
        if(!empty($contrato))
        {
            $plano = new Plano($contrato['idPlano'],null,null,null,null,null);
            $plano->obterPlanoPorId($conn);
            $this->setPlano($plano);
            $aluno = new Aluno($contrato['idAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
            $aluno->obterAlunoPorId($conn);
            $this->setIdContrato($contrato['idContrato']);
            $this->setAluno($aluno);
            $formaPagamento = new FormaPagamento($contrato['idFormaPagamento'],null,null);
            $formaPagamento->obterFormaPagamentoPorId($conn);
            $this->setFormaPagamento($formaPagamento);
            $this->setDataInicio($contrato['dataInicio']);
            $this->setDataFim($contrato['dataFim']);
            $this->setDataContrato($contrato['dataContrato']);
            $this->setDataCancelamento($contrato['dataCancelamento']);
            $this->setValor($contrato['valor']);
            $this->setDiaPagamento($contrato['diaPagamento']);
            $retorno = true;
        }
        return $retorno;
    }

    public function cancelar(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.contrato SET dataCancelamento = curdate() WHERE idContrato = :idContrato");
            $stmt->bindValue(":idContrato",$this->getIdContrato(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {

        }
    }

    public function alterarDiaPagamento(?\PDO $conn)
    {
        $ret = false;
        try{
            $stmt = $conn->prepare("UPDATE feminina.contrato SET diaPagamento = :diaPagamento WHERE idContrato = :idContrato");
            $stmt->bindValue(":diaPagamento",$this->getDiaPagamento(),\PDO::PARAM_INT);
            $stmt->bindValue(":idContrato",$this->getIdContrato(),\PDO::PARAM_INT);
            if($stmt->execute())
            {
                $stmt = $conn->prepare("SELECT * FROM feminina.mensalidade WHERE idContrato = :idContrato AND dataPagamento IS null");
                $stmt->bindValue(":idContrato",$this->getIdContrato(),\PDO::PARAM_INT);
                $stmt->execute();
                $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                if(!empty($dados) && is_array($dados) && count($dados))
                {
                    $datasMensalidadesAtualizadas = [];
                    foreach ($dados as $dado)
                    {
                        $stmt = $conn->prepare("UPDATE feminina.mensalidade SET dataMensalidade = :dataMensalidade WHERE idMensalidade = :idMensalidade");
                        $stmt->bindValue(":idMensalidade",$dado['idMensalidade'],\PDO::PARAM_INT);
                        $tam = strlen($dado['dataMensalidade']) - 2;
                        $novoDia = substr($dado['dataMensalidade'],0,$tam).$this->getDiaPagamento();
                        $stmt->bindValue(":dataMensalidade",$novoDia,\PDO::PARAM_STR);
                        $datasMensalidadesAtualizadas[] = $stmt->execute();
                    }
                    if(!in_array(false,$datasMensalidadesAtualizadas))
                    {
                        $ret = true;
                    }
                }
            }
        }catch (\PDOException $e)
        {

        }
        return $ret;
    }

    public function obterTodosContratosAtivos(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idContrato, idPlano, idAluno, idFormaPagamento, dataInicio, dataFim, dataContrato, dataCancelamento, valor, diaPagamento FROM feminina.contrato WHERE dataCancelamento is null");
        $stmt->execute();
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            foreach ($dados as $key => $dado)
            {
                $aluno = new Aluno($dado['idAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $aluno->obterAlunoPorId($conn);
                $dados[$key]['idAluno'] = ObjectHelper::dismount($aluno);
            }
        }
        return $dados;
    }

    public function obterTodosContratosPeriodo(?\PDO $conn)
    {
        try{
            $sql = "SELECT ct.idContrato AS codigoContrato,
                    al.nome AS nomeAluno,
                    pl.descricao AS plano,
                    fp.descricao AS formaPagamento,
                    DATE_FORMAT(ct.dataInicio,'%d/%m/%Y') AS dataInicio,
                    DATE_FORMAT(ct.dataFim,'%d/%m/%Y') AS dataFim,
                    DATE_FORMAT(ct.dataContrato,'%d/%m/%Y') AS dataContrato,
                    IF(ct.dataCancelamento IS not NULL,'NÃO','SIM') AS ativo,
                    IF(ct.dataCancelamento is not null,DATE_FORMAT(ct.dataCancelamento,'%d/%m/%Y'),'') AS dataCancelamento,
                    FORMAT(ct.valor,2,'de_DE') AS valorMensalidade,
                    ct.diaPagamento AS diaPagamento
                    FROM feminina.contrato ct 
                    JOIN feminina.plano pl ON (pl.idPlano = ct.idPlano)
                    JOIN feminina.aluno al ON (al.idAluno = ct.idAluno)
                    JOIN feminina.formapagamento fp ON (fp.idFormaPagamento = ct.idFormaPagamento)
                    WHERE ct.datacontrato BETWEEN :dataInicio AND :dataFim
                    order by dataCancelamento asc";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":dataInicio",$this->getDataInicio(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$this->getDataFim(),\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }
}