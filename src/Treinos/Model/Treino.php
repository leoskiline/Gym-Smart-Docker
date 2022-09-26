<?php

namespace App\Treinos\Model;

class Treino
{
    private $idTreino;
    private $contrato;
    private $data;
    private $dataInicio;
    private $dataFim;
    private $administrador;
    private $instrutor;
    private $exerciciosFisicos;
    private $avaliacaoFisica;

    /**
     * @param $idTreino
     * @param $contrato
     * @param $data
     * @param $dataInicio
     * @param $dataFim
     * @param $administrador
     * @param $instrutor
     * @param $exerciciosFisicos
     * @param $avaliacaoFisica
     */
    public function __construct($idTreino, $contrato, $data, $dataInicio, $dataFim, $administrador, $instrutor, $exerciciosFisicos, $avaliacaoFisica)
    {
        $this->idTreino = $idTreino;
        $this->contrato = $contrato;
        $this->data = $data;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->administrador = $administrador;
        $this->instrutor = $instrutor;
        $this->exerciciosFisicos = $exerciciosFisicos;
        $this->avaliacaoFisica = $avaliacaoFisica;
    }


    /**
     * @return mixed
     */
    public function getAvaliacaoFisica()
    {
        return $this->avaliacaoFisica;
    }

    /**
     * @param mixed $avaliacaoFisica
     */
    public function setAvaliacaoFisica($avaliacaoFisica): void
    {
        $this->avaliacaoFisica = $avaliacaoFisica;
    }

    /**
     * @return mixed
     */
    public function getIdTreino()
    {
        return $this->idTreino;
    }

    /**
     * @param mixed $idTreino
     */
    public function setIdTreino($idTreino): void
    {
        $this->idTreino = $idTreino;
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
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * @param mixed $administrador
     */
    public function setAdministrador($administrador): void
    {
        $this->administrador = $administrador;
    }

    /**
     * @return mixed
     */
    public function getInstrutor()
    {
        return $this->instrutor;
    }

    /**
     * @param mixed $instrutor
     */
    public function setInstrutor($instrutor): void
    {
        $this->instrutor = $instrutor;
    }

    /**
     * @return mixed
     */
    public function getExerciciosFisicos()
    {
        return $this->exerciciosFisicos;
    }

    /**
     * @param mixed $exerciciosFisicos
     */
    public function setExerciciosFisicos($exerciciosFisicos): void
    {
        $this->exerciciosFisicos = $exerciciosFisicos;
    }

    public function gravar(?\PDO $conn)
    {
        $gravou = [];
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.treino (idContrato, data, dataInicio, dataFim,idAvaliacaoFisica) VALUES (:idContrato, :data, :dataInicio, :dataFim,:idAvaliacaoFisica)");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->bindValue(":data",$this->getData(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataInicio",$this->getDataInicio(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$this->getDataFim(),\PDO::PARAM_STR);
            $stmt->bindValue(":idAvaliacaoFisica",$this->getAvaliacaoFisica() ? $this->getAvaliacaoFisica()->getIdAvaliacaoFisica() : null,\PDO::PARAM_STR);
            $gravou[] = $stmt->execute();
            $this->setIdTreino($conn->lastInsertId());
            if(!empty($this->getAdministrador()))
            {
                $sql = "INSERT INTO feminina.treino_has_administrador (Treino_idTreino, Administrador_idAdministrador) VALUES (:idTreino,:id)";
                $id = $this->getAdministrador()->getIdAdministrador();
            }else if(!empty($this->getInstrutor()))
            {
                $sql = "INSERT INTO feminina.treino_has_instrutor (Treino_idTreino, Instrutor_idInstrutor) VALUES (:idTreino,:id)";
                $id = $this->getInstrutor()->getIdInstrutor();
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id",$id,\PDO::PARAM_INT);
            $stmt->bindValue(":idTreino",$this->getIdTreino(),\PDO::PARAM_INT);
            $gravou[] = $stmt->execute();
            $gravouExercicios = [];
            foreach ($this->getExerciciosFisicos() as $exercicio)
            {
                $stmt = $conn->prepare("INSERT INTO feminina.treino_has_exerciciofisico (Treino_idTreino, ExercicioFisico_idExercicioFisico, series, repeticoes, peso, dia) 
                                            VALUES (:Treino_idTreino, :ExercicioFisico_idExercicioFisico, :series, :repeticoes, :peso, :diaExercicio)");
                $stmt->bindValue(":Treino_idTreino",$this->getIdTreino(),\PDO::PARAM_INT);
                $stmt->bindValue(":ExercicioFisico_idExercicioFisico",$exercicio['exercicio'],\PDO::PARAM_INT);
                $stmt->bindValue(":series",$exercicio['series'],\PDO::PARAM_STR);
                $stmt->bindValue(":repeticoes",$exercicio['repeticoes'],\PDO::PARAM_STR);
                $stmt->bindValue(":peso",$exercicio['pesoSugerido'],\PDO::PARAM_STR);
                $stmt->bindValue(":diaExercicio",$exercicio['diaExercicio'],\PDO::PARAM_STR);
                $gravouExercicios[] = $stmt->execute();
            }
            $gravou[] = !in_array(false,$gravouExercicios);
            return !in_array(false,$gravou);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterUltimoTreino(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT dataInicio,dataFim 
                from feminina.treino 
            WHERE idContrato = :idContrato AND dataInicio BETWEEN :dataInicio AND :dataFim OR dataFim BETWEEN :dataInicio AND :dataFim order by dataInicio desc limit 1;");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->bindValue(":dataInicio",$this->getDataInicio(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataFim",$this->getDataFim(),\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterTodos(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT t.idTreino,
                                            DATE_FORMAT(t.data,'%d/%m/%Y %H:%i:%s') AS dataCriacao,
                                            DATE_FORMAT(t.dataInicio,'%d/%m/%Y') AS dataInicio,
                                            DATE_FORMAT(t.dataFim,'%d/%m/%Y') AS dataFim,
                                            a.nome AS nomeCliente,
                                            tha.Administrador_idAdministrador AS idAdministrador,
                                            adm.nome AS nomeAdministrador,
                                            thi.Instrutor_idInstrutor AS idInstrutor,
                                            ins.nome AS nomeInstrutor,
                                            af.idAvaliacaoFisica,
                                            aaf.tipoAvaliacao,
                                            DATE_FORMAT(aaf.start,'%d/%m/%Y') AS dataAvaliacao,
                                            FORMAT(aaf.valor,2,'de_DE') AS valorAvaliacao
                                            FROM feminina.treino t
                                            JOIN feminina.contrato c ON (c.idContrato = t.idContrato)
                                            JOIN feminina.aluno a ON (a.idAluno = c.idAluno)
                                            LEFT JOIN feminina.treino_has_administrador tha ON (tha.Treino_idTreino = t.idTreino)
                                            LEFT JOIN feminina.treino_has_instrutor thi ON (thi.Treino_idTreino = t.idTreino)
                                            LEFT JOIN feminina.administrador adm ON (adm.idAdministrador = tha.Administrador_idAdministrador)
                                            LEFT JOIN feminina.instrutor ins ON (ins.idInstrutor = thi.Instrutor_idInstrutor)
                                            LEFT JOIN feminina.avaliacaofisica af ON (af.idAvaliacaoFisica = t.idAvaliacaoFisica)
                                            LEFT JOIN feminina.agendamentosavaliacaofisica aaf ON (aaf.idAgendamentoAvaliacaoFisica = af.idAgendamentoAvaliacaoFisica)
                                            ORDER BY DATA DESC");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterAvaliacaoFisicaPorContrato(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT cont.idContrato AS contrato,
                                                aavf.tipoAvaliacao AS tipo,
                                                af.idAvaliacaoFisica AS idAvaliacaoFisica,
                                                aavf.`start` AS inicio,
                                                aavf.`end` AS fim,
                                                aavf.title AS nome
                                          FROM feminina.contrato cont
                                          JOIN feminina.agendamentosavaliacaofisica aavf ON (aavf.idAluno = cont.idAluno)
                                          JOIN feminina.avaliacaofisica af ON (af.idAgendamentoAvaliacaoFisica = aavf.idAgendamentoAvaliacaoFisica)
                                          WHERE cont.idContrato = :idContrato AND cont.dataCancelamento IS null
                                          ORDER BY aavf.start DESC
                                          LIMIT 1");
            $stmt->bindValue(":idContrato",$this->getContrato()->getIdContrato(),\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterExerciciosPorTreino(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT 
                                            the.dia,
                                            gm.descricao AS grupomuscular,
                                            exs.descricao AS exerciciofisico,
                                            the.series,
                                            the.repeticoes,
                                            the.peso
                                            FROM feminina.treino tr
                                            JOIN feminina.treino_has_exerciciofisico the ON (the.Treino_idTreino = tr.idTreino)
                                            JOIN feminina.exerciciofisico exs ON (exs.idExercicioFisico = the.ExercicioFisico_idExercicioFisico)
                                            JOIN feminina.grupomuscular gm ON (gm.idGrupoMuscular = exs.idGrupoMuscular)
                                            WHERE tr.idTreino = :idTreino ORDER BY the.dia asc");
            $stmt->bindValue(":idTreino",$this->getIdTreino(),\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterDadosPessoaisPorTreino(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT 
                                            tr.idTreino,
                                            tr.idContrato,
                                            if(tr.idAvaliacaoFisica IS NOT NULL, 'SIM', 'NÃO') AS avaliacaofisica,
                                            pla.descricao AS plano,
                                            alu.nome AS aluno,
                                            if(adm.idAdministrador IS NOT NULL,adm.nome, IF(ins.idInstrutor IS NOT NULL,ins.nome,NULL)) AS treinador
                                            FROM feminina.treino tr
                                            JOIN feminina.contrato cont ON (cont.idContrato = tr.idContrato)
                                            JOIN feminina.aluno alu ON (alu.idAluno = cont.idAluno)
                                            JOIN feminina.plano pla ON (pla.idPlano = cont.idPlano)
                                            LEFT JOIN feminina.treino_has_administrador tha ON (tha.Treino_idTreino = tr.idTreino)
                                            LEFT JOIN feminina.treino_has_instrutor thi ON (thi.Treino_idTreino = tr.idTreino)
                                            LEFT JOIN feminina.administrador adm ON (adm.idAdministrador = tha.Administrador_idAdministrador)
                                            LEFT JOIN feminina.instrutor ins ON (ins.idInstrutor = thi.Instrutor_idInstrutor)
                                            WHERE tr.idTreino = :idTreino");
            $stmt->bindValue(":idTreino",$this->getIdTreino(),\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

}