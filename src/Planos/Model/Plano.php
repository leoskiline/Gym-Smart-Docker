<?php

namespace App\Planos\Model;

class Plano
{
    private $idPlano;
    private $descricao;
    private $idTipoPlano;
    private $valorPadrao;
    private $percentualDesconto;
    private $valorComDesconto;

    /**
     * @param $idPlano
     * @param $descricao
     * @param $idTipoPlano
     * @param $valorPadrao
     * @param $percentualDesconto
     * @param $valorComDesconto
     */
    public function __construct($idPlano, $descricao, $idTipoPlano, $valorPadrao, $percentualDesconto, $valorComDesconto)
    {
        $this->idPlano = $idPlano;
        $this->descricao = $descricao;
        $this->idTipoPlano = $idTipoPlano;
        $this->valorPadrao = $valorPadrao;
        $this->percentualDesconto = $percentualDesconto;
        $this->valorComDesconto = $valorComDesconto;
    }

    /**
     * @return mixed
     */
    public function getIdPlano()
    {
        return $this->idPlano;
    }

    /**
     * @param mixed $idPlano
     */
    public function setIdPlano($idPlano): void
    {
        $this->idPlano = $idPlano;
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
    public function getIdTipoPlano()
    {
        return $this->idTipoPlano;
    }

    /**
     * @param mixed $idTipoPlano
     */
    public function setIdTipoPlano($idTipoPlano): void
    {
        $this->idTipoPlano = $idTipoPlano;
    }

    /**
     * @return mixed
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * @param mixed $valorPadrao
     */
    public function setValorPadrao($valorPadrao): void
    {
        $this->valorPadrao = $valorPadrao;
    }

    /**
     * @return mixed
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * @param mixed $percentualDesconto
     */
    public function setPercentualDesconto($percentualDesconto): void
    {
        $this->percentualDesconto = $percentualDesconto;
    }

    /**
     * @return mixed
     */
    public function getValorComDesconto()
    {
        return $this->valorComDesconto;
    }

    /**
     * @param mixed $valorComDesconto
     */
    public function setValorComDesconto($valorComDesconto): void
    {
        $this->valorComDesconto = $valorComDesconto;
    }

    private function diferente()
    {
        $sql = "";
        if(!empty($this->getIdPlano()))
        {
            $sql = " AND idPlano <> :idPlano";
        }
        return $sql;
    }

    public function verificarExiste(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idPlano FROM feminina.plano WHERE descricao = :descricao {$this->diferente()}");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        if(!empty($this->getIdPlano()))
            $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }


    public function gravar(?\PDO $conn,array $atividades)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.plano (descricao, valorPadrao,tipoPlano, percentualDesconto,valorComDesconto) VALUES (:descricao,:valorPadrao,:tipoPlano,:percentualDesconto,:valorComDesconto) ");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":valorPadrao",$this->getValorPadrao(),\PDO::PARAM_STR);
        $stmt->bindValue(":percentualDesconto",$this->getPercentualDesconto(),\PDO::PARAM_STR);
        $stmt->bindValue(":tipoPlano",$this->getIdTipoPlano(),\PDO::PARAM_INT);
        $stmt->bindValue(":valorComDesconto",$this->getValorComDesconto(),\PDO::PARAM_STR);
        $plano = $stmt->execute();
        $this->setIdPlano($conn->lastInsertId());
        foreach ($atividades as $atividade)
        {
            $stmt = $conn->prepare("INSERT INTO feminina.plano_has_atividadefisica (Plano_idPlano, AtividadeFisica_idAtividadeFisica) VALUES (:idPlano,:idAtividade)");
            $stmt->bindValue(":idAtividade",$atividade,\PDO::PARAM_INT);
            $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
            $atividadesFisicas[] = $stmt->execute();
        }
        return $plano && !in_array(false,$atividadesFisicas);
    }

    public function obterTodos(?\PDO $conn)
    {
        $stmt = $conn->prepare("select pl.idPlano,
                                        pl.descricao,
                                        pl.valorPadrao,
                                        pl.tipoPlano,
                                        pl.percentualDesconto,
                                        pl.valorComDesconto,
                                        group_concat(atv.descricao) as atividadesFisicas,
                                        group_concat(atv.idAtividadeFisica) as idAtividadesFisicas
                                        from feminina.plano pl
                                        join feminina.plano_has_atividadefisica pha on (pha.Plano_idPlano = pl.idPlano)
                                        join feminina.atividadefisica atv on (atv.idAtividadeFisica = pha.AtividadeFisica_idAtividadeFisica)
                                        WHERE atv.ativa = 1
                                        group by pl.idPlano
                                        order by pl.descricao desc");
        $stmt->execute();
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(is_array($dados))
        {
            foreach ($dados as $key => $dado)
            {
                $dados[$key]['atividadesFisicas'] = explode(",",$dado['atividadesFisicas']);
                $dados[$key]['idAtividadesFisicas'] = explode(",",$dado['idAtividadesFisicas']);
            }
        }
        return $dados;
    }

    public function deletar(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.plano_has_atividadefisica WHERE Plano_idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $planoAtividade = $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM feminina.plano where idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $plano = $stmt->execute();
        return $plano && $planoAtividade;
    }

    public function atualizar(?\PDO $conn, array $atividadesFisicasModal)
    {
        $stmt = $conn->prepare("UPDATE feminina.plano SET descricao = :descricao, valorPadrao = :valorPadrao,tipoPlano = :tipoPlano, percentualDesconto = :percentualDesconto, valorComDesconto = :valorComDesconto WHERE idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $stmt->bindValue(":tipoPlano",$this->getIdTipoPlano(),\PDO::PARAM_INT);
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":valorPadrao",$this->getValorPadrao(),\PDO::PARAM_STR);
        $stmt->bindValue(":percentualDesconto",$this->getPercentualDesconto(),\PDO::PARAM_STR);
        $stmt->bindValue(":valorComDesconto",$this->getValorComDesconto(),\PDO::PARAM_STR);
        $atualizado = $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM feminina.plano_has_atividadefisica WHERE Plano_idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $deletado = $stmt->execute();
        if(is_array($atividadesFisicasModal))
        {
            foreach ($atividadesFisicasModal as $atividade)
            {
                $stmt = $conn->prepare("INSERT INTO feminina.plano_has_atividadefisica (Plano_idPlano, AtividadeFisica_idAtividadeFisica) VALUES (:idPlano,:atividadeFisica)");
                $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
                $stmt->bindValue(":atividadeFisica",$atividade,\PDO::PARAM_INT);
                $atividades[] = $stmt->execute();
            }
        }
        return $atualizado && $deletado && !in_array(false,$atividades);
    }

    public function obterPlanoPorId(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idPlano, descricao,tipoPlano, valorPadrao, percentualDesconto, valorComDesconto FROM feminina.plano WHERE idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $stmt->execute();
        $plano = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->setDescricao($plano['descricao']);
        $this->setValorPadrao($plano['valorPadrao']);
        $this->setIdTipoPlano($plano['tipoPlano']);
        $this->setPercentualDesconto($plano['percentualDesconto']);
        $this->setValorComDesconto($plano['valorComDesconto']);
    }

    public function verificarVinculadoMatricula(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.contrato WHERE idPlano = :idPlano");
        $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterAtividadesFisicas(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT group_concat(distinct(atv.descricao)) as descricao FROM feminina.plano pla
JOIN feminina.plano_has_atividadefisica pha ON (pha.Plano_idPlano)
JOIN feminina.atividadefisica atv ON (atv.idAtividadeFisica = pha.AtividadeFisica_idAtividadeFisica)
WHERE pla.idPlano = :idPlano");
            $stmt->bindValue(":idPlano",$this->getIdPlano(),\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }
}