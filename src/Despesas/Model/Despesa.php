<?php

namespace App\Despesas\Model;

class Despesa
{
    private $idDespesa;
    private $fornecedor;
    private $usuario;
    private $descricao;
    private $tipo;
    private $dataVencimento;
    private $valorPagamento;
    private $dataPagamento;
    private $valorDespesa;

    /**
     * @param $idDespesa
     * @param $fornecedor
     * @param $usuario
     * @param $descricao
     * @param $tipo
     * @param $dataVencimento
     * @param $valorPagamento
     * @param $dataPagamento
     * @param $valorDespesa
     */
    public function __construct($idDespesa, $fornecedor, $usuario, $descricao, $tipo, $dataVencimento, $valorPagamento, $dataPagamento, $valorDespesa)
    {
        $this->idDespesa = $idDespesa;
        $this->fornecedor = $fornecedor;
        $this->usuario = $usuario;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
        $this->dataVencimento = $dataVencimento;
        $this->valorPagamento = $valorPagamento ? $valorPagamento : null;
        $this->dataPagamento = $dataPagamento ? $dataPagamento : null;
        $this->valorDespesa = $valorDespesa;
    }

    /**
     * @return mixed
     */
    public function getIdDespesa()
    {
        return $this->idDespesa;
    }

    /**
     * @param mixed $idDespesa
     */
    public function setIdDespesa($idDespesa): void
    {
        $this->idDespesa = $idDespesa;
    }

    /**
     * @return mixed
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * @param mixed $fornecedor
     */
    public function setFornecedor($fornecedor): void
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * @param mixed $dataVencimento
     */
    public function setDataVencimento($dataVencimento): void
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * @return mixed
     */
    public function getValorPagamento()
    {
        return $this->valorPagamento;
    }

    /**
     * @param mixed $valorPagamento
     */
    public function setValorPagamento($valorPagamento): void
    {
        $this->valorPagamento = $valorPagamento;
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

    /**
     * @return mixed
     */
    public function getValorDespesa()
    {
        return $this->valorDespesa;
    }

    /**
     * @param mixed $valorDespesa
     */
    public function setValorDespesa($valorDespesa): void
    {
        $this->valorDespesa = $valorDespesa;
    }

    public function gravar(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.despesa 
            (idFornecedor, idUsuario, descricao, tipo, dataVencimento, valorPagamento, dataPagamento, valorDespesa) 
            VALUES (:idFornecedor, :idUsuario, :descricao, :tipo, :dataVencimento, :valorPagamento, :dataPagamento, :valorDespesa)");
            $stmt->bindValue(":idFornecedor",$this->getFornecedor()->getIdFornecedor(),\PDO::PARAM_INT);
            $stmt->bindValue(":idUsuario",$this->getUsuario()->getIdUsuario(),\PDO::PARAM_INT);
            $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
            $stmt->bindValue(":tipo",$this->getTipo(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataVencimento",$this->getDataVencimento(),\PDO::PARAM_STR);
            $stmt->bindValue(":valorPagamento",!empty($this->getValorPagamento()) ? $this->getValorPagamento() : null,\PDO::PARAM_STR);
            $stmt->bindValue(":dataPagamento",!empty($this->getDataPagamento()) ? $this->getDataPagamento() : null,\PDO::PARAM_STR);
            $stmt->bindValue(":valorDespesa",$this->getValorDespesa(),\PDO::PARAM_STR);
            return $stmt->execute();
        }catch (\PDOException $e)
        {

        }
    }

    public function obterTodos(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT 
                                        d.idDespesa,
                                        f.idFornecedor,
                                        f.descricao AS nomeFornecedor,
                                        a.nome AS nomeUsuario,
                                        d.descricao,
                                        d.tipo,
                                        d.dataVencimento,
                                        d.valorPagamento,
                                        d.dataPagamento,
                                        d.valorDespesa
                                        FROM feminina.despesa d
                                        JOIN feminina.fornecedor f ON (f.idFornecedor = d.idFornecedor)
                                        JOIN feminina.usuario u ON (u.idUsuario = d.idUsuario)
                                        JOIN feminina.administrador a ON (a.idAdministrador = u.idAdministrador)");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deletar(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.despesa WHERE idDespesa = :idDespesa");
        $stmt->bindValue(":idDespesa",$this->getIdDespesa(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.despesa SET idFornecedor = :idFornecedor,idUsuario = :idUsuario,descricao = :descricao,tipo = :tipo,dataVencimento = :dataVencimento,valorPagamento = :valorPagamento,dataPagamento = :dataPagamento,valorDespesa = :valorDespesa WHERE idDespesa = :idDespesa");
        $stmt->bindValue(":idDespesa",$this->getIdDespesa(),\PDO::PARAM_INT);
        $stmt->bindValue(":idFornecedor",$this->getFornecedor()->getIdFornecedor(),\PDO::PARAM_INT);
        $stmt->bindValue(":idUsuario",$this->getUsuario()->getIdUsuario(),\PDO::PARAM_INT);
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":tipo",$this->getTipo(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataVencimento",$this->getDataVencimento(),\PDO::PARAM_STR);
        $stmt->bindValue(":valorPagamento",$this->getValorPagamento(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataPagamento",$this->getDataPagamento(),\PDO::PARAM_STR);
        $stmt->bindValue(":valorDespesa",$this->getValorDespesa(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obterTodosPeriodo(?\PDO $conn, array $dados)
    {
        try{
            $stmt = $conn->prepare("SELECT
                                                xt.tipo AS tipo,
                                                xt.descricao AS descricao,
                                                DATE_FORMAT(xt.data,'%d/%m/%Y') AS data,
                                                FORMAT(xt.valor,2,'de_DE') AS valor ,
                                                if(xt.dataPagamento IS NOT NULL,if(DATE_FORMAT(xt.dataPagamento,'%d/%m/%Y') IS NOT NULL,'PAGAMENTO EFETUADO','RECEBIDO'),'PAGAMENTO PENDENTE') AS operacao
                                            FROM
                                            (SELECT 'DESPESA' AS tipo,descricao,dataVencimento AS data,valorDespesa AS valor, dataPagamento, idDespesa as id
                                            FROM feminina.despesa
                                            UNION
                                            SELECT 'RECEITA' AS tipo,origem AS descricao,data,valor AS valor,'' AS dataPagamento ,idReceita AS id
                                            FROM feminina.receita) AS xt
                                            WHERE xt.data BETWEEN :dataInicio AND :dataFim
                                            order by data desc");
            $stmt->bindValue(":dataInicio",$dados['dataInicial'],\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$dados['dataFinal'],\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterSomaDespesasPeriodo(?\PDO $conn, array $dados)
    {
        try{
            $stmt = $conn->prepare("SELECT sum(valorDespesa) as valor
                                            FROM feminina.despesa
                                            WHERE dataVencimento between :dataInicio and :dataFim");
            $stmt->bindValue(":dataInicio",$dados['dataInicial'],\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$dados['dataFinal'],\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterSomaReceitasPeriodo(?\PDO $conn, array $dados)
    {
        try{
            $stmt = $conn->prepare("SELECT sum(valor) as valor
                                            FROM feminina.receita
                                            where data between :dataInicio AND :dataFim");
            $stmt->bindValue(":dataInicio",$dados['dataInicial'],\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$dados['dataFinal'],\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }
}