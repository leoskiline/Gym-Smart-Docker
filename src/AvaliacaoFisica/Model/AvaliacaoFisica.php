<?php

namespace App\AvaliacaoFisica\Model;

use App\AgendamentoAvaliacao\Model\AgendamentoAvaliacao;

class AvaliacaoFisica
{
    private $idAvaliacaoFisica;
    private $idAgendamentoAvaliacaoFisica;
    private $nivelaptidaofisica;
    private $peso;
    private $altura;
    private $dores;
    private $historicosaude;
    private $desviospostura;
    private $percentualgordura;
    private $percentualmassamagra;
    private $metas;
    private $objetivo;
    private $habitosalimentares;
    private $qualidadesono;
    private $bebidaalcoolica;
    private $fumante;
    private $medicamentos;

    /**
     * @param $idAvaliacaoFisica
     * @param $idAgendamentoAvaliacaoFisica
     * @param $nivelaptidaofisica
     * @param $peso
     * @param $altura
     * @param $dores
     * @param $historicosaude
     * @param $desviospostura
     * @param $percentualgordura
     * @param $percentualmassamagra
     * @param $metas
     * @param $objetivo
     * @param $habitosalimentares
     * @param $qualidadesono
     * @param $bebidaalcoolica
     * @param $fumante
     * @param $medicamentos
     */
    public function __construct($idAvaliacaoFisica, $idAgendamentoAvaliacaoFisica, $nivelaptidaofisica, $peso, $altura, $dores, $historicosaude, $desviospostura, $percentualgordura, $percentualmassamagra, $metas, $objetivo, $habitosalimentares, $qualidadesono, $bebidaalcoolica, $fumante, $medicamentos)
    {
        $this->idAvaliacaoFisica = $idAvaliacaoFisica;
        $this->idAgendamentoAvaliacaoFisica = $idAgendamentoAvaliacaoFisica;
        $this->nivelaptidaofisica = $nivelaptidaofisica;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->dores = $dores;
        $this->historicosaude = $historicosaude;
        $this->desviospostura = $desviospostura;
        $this->percentualgordura = $percentualgordura;
        $this->percentualmassamagra = $percentualmassamagra;
        $this->metas = $metas;
        $this->objetivo = $objetivo;
        $this->habitosalimentares = $habitosalimentares;
        $this->qualidadesono = $qualidadesono;
        $this->bebidaalcoolica = $bebidaalcoolica;
        $this->fumante = $fumante;
        $this->medicamentos = $medicamentos;
    }

    /**
     * @return mixed
     */
    public function getIdAvaliacaoFisica()
    {
        return $this->idAvaliacaoFisica;
    }

    /**
     * @param mixed $idAvaliacaoFisica
     */
    public function setIdAvaliacaoFisica($idAvaliacaoFisica): void
    {
        $this->idAvaliacaoFisica = $idAvaliacaoFisica;
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

    /**
     * @return mixed
     */
    public function getNivelaptidaofisica()
    {
        return $this->nivelaptidaofisica;
    }

    /**
     * @param mixed $nivelaptidaofisica
     */
    public function setNivelaptidaofisica($nivelaptidaofisica): void
    {
        $this->nivelaptidaofisica = $nivelaptidaofisica;
    }

    /**
     * @return mixed
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso): void
    {
        $this->peso = $peso;
    }

    /**
     * @return mixed
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * @param mixed $altura
     */
    public function setAltura($altura): void
    {
        $this->altura = $altura;
    }

    /**
     * @return mixed
     */
    public function getDores()
    {
        return $this->dores;
    }

    /**
     * @param mixed $dores
     */
    public function setDores($dores): void
    {
        $this->dores = $dores;
    }

    /**
     * @return mixed
     */
    public function getHistoricosaude()
    {
        return $this->historicosaude;
    }

    /**
     * @param mixed $historicosaude
     */
    public function setHistoricosaude($historicosaude): void
    {
        $this->historicosaude = $historicosaude;
    }

    /**
     * @return mixed
     */
    public function getDesviospostura()
    {
        return $this->desviospostura;
    }

    /**
     * @param mixed $desviospostura
     */
    public function setDesviospostura($desviospostura): void
    {
        $this->desviospostura = $desviospostura;
    }

    /**
     * @return mixed
     */
    public function getPercentualgordura()
    {
        return $this->percentualgordura;
    }

    /**
     * @param mixed $percentualgordura
     */
    public function setPercentualgordura($percentualgordura): void
    {
        $this->percentualgordura = $percentualgordura;
    }

    /**
     * @return mixed
     */
    public function getPercentualmassamagra()
    {
        return $this->percentualmassamagra;
    }

    /**
     * @param mixed $percentualmassamagra
     */
    public function setPercentualmassamagra($percentualmassamagra): void
    {
        $this->percentualmassamagra = $percentualmassamagra;
    }

    /**
     * @return mixed
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * @param mixed $metas
     */
    public function setMetas($metas): void
    {
        $this->metas = $metas;
    }

    /**
     * @return mixed
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * @param mixed $objetivo
     */
    public function setObjetivo($objetivo): void
    {
        $this->objetivo = $objetivo;
    }

    /**
     * @return mixed
     */
    public function getHabitosalimentares()
    {
        return $this->habitosalimentares;
    }

    /**
     * @param mixed $habitosalimentares
     */
    public function setHabitosalimentares($habitosalimentares): void
    {
        $this->habitosalimentares = $habitosalimentares;
    }

    /**
     * @return mixed
     */
    public function getQualidadesono()
    {
        return $this->qualidadesono;
    }

    /**
     * @param mixed $qualidadesono
     */
    public function setQualidadesono($qualidadesono): void
    {
        $this->qualidadesono = $qualidadesono;
    }

    /**
     * @return mixed
     */
    public function getBebidaalcoolica()
    {
        return $this->bebidaalcoolica;
    }

    /**
     * @param mixed $bebidaalcoolica
     */
    public function setBebidaalcoolica($bebidaalcoolica): void
    {
        $this->bebidaalcoolica = $bebidaalcoolica;
    }

    /**
     * @return mixed
     */
    public function getFumante()
    {
        return $this->fumante;
    }

    /**
     * @param mixed $fumante
     */
    public function setFumante($fumante): void
    {
        $this->fumante = $fumante;
    }

    /**
     * @return mixed
     */
    public function getMedicamentos()
    {
        return $this->medicamentos;
    }

    /**
     * @param mixed $medicamentos
     */
    public function setMedicamentos($medicamentos): void
    {
        $this->medicamentos = $medicamentos;
    }



    public function gravar(?\PDO $conn)
    {
        try{
            $stmt=  $conn->prepare("INSERT INTO feminina.avaliacaofisica 
        (nivelaptidaofisica, peso, altura, dores, historicosaude, desviospostura, percentualgordura, percentualmassamagra, metas, objetivo,
         habitosalimentares, qualidadesono, bebidaalcoolica, fumante, medicamentos , idAgendamentoAvaliacaoFisica) 
         VALUES (:nivelaptidaofisica, :peso, :altura, :dores, :historicosaude, :desviospostura, :percentualgordura, :percentualmassamagra, :metas, :objetivo,
                 :habitosalimentares, :qualidadesono, :bebidaalcoolica, :fumante, :medicamentos, :idAgendamentoAvaliacaoFisica)");
            $stmt->bindValue(":nivelaptidaofisica",!empty($this->getNivelaptidaofisica()) ? $this->getNivelaptidaofisica() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":peso",!empty($this->getPeso()) ? $this->getPeso() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":altura",!empty($this->getAltura()) ? $this->getAltura() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":dores",!empty($this->getDores()) ? $this->getDores() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":historicosaude",!empty($this->getHistoricosaude()) ? $this->getHistoricosaude() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":desviospostura",!empty($this->getDesviospostura()) ? $this->getDesviospostura() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":percentualgordura",!empty($this->getPercentualgordura()) ? $this->getPercentualgordura() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":percentualmassamagra",!empty($this->getPercentualmassamagra()) ? $this->getPercentualmassamagra() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":metas",!empty($this->getMetas()) ? $this->getMetas() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":objetivo",!empty($this->getObjetivo()) ? $this->getObjetivo() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":habitosalimentares",!empty($this->getHabitosalimentares()) ? $this->getHabitosalimentares() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":qualidadesono",!empty($this->getQualidadesono()) ? $this->getQualidadesono() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":bebidaalcoolica",!empty($this->getBebidaalcoolica()) ? $this->getBebidaalcoolica() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":fumante",!empty($this->getFumante()) ? $this->getFumante() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":medicamentos",!empty($this->getMedicamentos()) ? $this->getMedicamentos() : "",\PDO::PARAM_STR);
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",!empty($this->getIdAgendamentoAvaliacaoFisica()->getIdAgendamentoAvaliacaoFisica()) ? $this->getIdAgendamentoAvaliacaoFisica()->getIdAgendamentoAvaliacaoFisica() : "",\PDO::PARAM_STR);
            return $stmt->execute();
        }catch (\PDOException $e)
        {

        }
    }

    public function obterAvaliacoesFisicas(?\PDO $conn,$params)
    {
        try{
            $criterio = "";
            if(!empty($params))
            {
                $criterio = " WHERE CONVERT(aaf.start,DATE) BETWEEN :dataInicio AND :dataFim";
            }
            $sql = "SELECT af.idAvaliacaoFisica,
                            af.idAgendamentoAvaliacaoFisica,
                            af.nivelaptidaofisica,
                            af.peso,
                            af.altura,
                            af.dores,
                            af.historicosaude,
                            af.desviospostura,
                            af.percentualgordura,
                            af.percentualmassamagra,
                            af.metas,
                            af.objetivo,
                            af.habitosalimentares,
                            af.qualidadesono,
                            af.bebidaalcoolica,
                            af.fumante,
                            af.medicamentos,
                            aaf.idInstrutor,
                            aaf.idAdministrador,
                            aaf.idAluno,
                            aaf.tipoAvaliacao,
                            aaf.`start` AS datahoraInicio,
                            aaf.end AS datahoraFim,
                            aaf.title,
                            aaf.color,
                            aaf.valor
                    FROM feminina.avaliacaofisica af
                    JOIN feminina.agendamentosavaliacaofisica aaf ON (aaf.idAgendamentoAvaliacaoFisica = af.idAgendamentoAvaliacaoFisica)
                    $criterio
                    ORDER BY aaf.start DESC";
            $stmt = $conn->prepare($sql);
            if(!empty($params))
            {
                $stmt->bindValue(":dataInicio",$params['dataInicial'],\PDO::PARAM_STR);
                $stmt->bindValue(":dataFim",$params['dataFinal'],\PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterAvaliacaoPorId(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idAvaliacaoFisica, idAgendamentoAvaliacaoFisica, nivelaptidaofisica, peso, altura, dores, historicosaude, desviospostura,
       percentualgordura, percentualmassamagra, metas, objetivo, habitosalimentares, qualidadesono, bebidaalcoolica, fumante, medicamentos
                                        FROM feminina.avaliacaofisica WHERE idAvaliacaoFisica = :idAvaliacaoFisica");
            $stmt->bindValue(":idAvaliacaoFisica",$this->getIdAvaliacaoFisica(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($dados))
            {
                $agendamento = new AgendamentoAvaliacao($dados['idAgendamentoAvaliacaoFisica'],null,null,null,null,null,null,null,null,null,null);
                $agendamento->obterAgendamentoPorId($conn);
                $this->setIdAgendamentoAvaliacaoFisica($agendamento);
                $this->setNivelaptidaofisica($dados['nivelaptidaofisica']);
                $this->setPeso($dados['peso']);
                $this->setAltura($dados['altura']);
                $this->setDores($dados['dores']);
                $this->setHistoricosaude($dados['historicosaude']);
                $this->setDesviospostura($dados['desviospostura']);
                $this->setPercentualgordura($dados['percentualgordura']);
                $this->setPercentualmassamagra($dados['percentualmassamagra']);
                $this->setMetas($dados['metas']);
                $this->setObjetivo($dados['objetivo']);
                $this->setHabitosalimentares($dados['habitosalimentares']);
                $this->setQualidadesono($dados['qualidadesono']);
                $this->setBebidaalcoolica($dados['bebidaalcoolica']);
                $this->setFumante($dados['fumante']);
                $this->setMedicamentos($dados['medicamentos']);
            }else{
                $this->setIdAvaliacaoFisica(null);
            }
        }catch (\PDOException $e)
        {

        }
    }


}