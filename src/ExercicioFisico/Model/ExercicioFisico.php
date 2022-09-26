<?php

namespace App\ExercicioFisico\Model;

class ExercicioFisico
{
    private $idExercicioFisico;
    private $descricao;
    private $grupoMuscular;

    /**
     * @param $idExercicioFisico
     * @param $descricao
     * @param $grupoMuscular
     */
    public function __construct($idExercicioFisico, $descricao, $grupoMuscular)
    {
        $this->idExercicioFisico = $idExercicioFisico;
        $this->descricao = $descricao;
        $this->grupoMuscular = $grupoMuscular;
    }

    /**
     * @return mixed
     */
    public function getIdExercicioFisico()
    {
        return $this->idExercicioFisico;
    }

    /**
     * @param mixed $idExercicioFisico
     */
    public function setIdExercicioFisico($idExercicioFisico): void
    {
        $this->idExercicioFisico = $idExercicioFisico;
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
    public function getGrupoMuscular()
    {
        return $this->grupoMuscular;
    }

    /**
     * @param mixed $grupoMuscular
     */
    public function setGrupoMuscular($grupoMuscular): void
    {
        $this->grupoMuscular = $grupoMuscular;
    }

    public function obterTodosVinculos(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT ef.idExercicioFisico,ef.descricao AS descricaoExercicio,gm.idGrupoMuscular,gm.descricao AS descricaoGrupo 
                                    FROM feminina.exerciciofisico ef
                                    JOIN feminina.grupomuscular gm ON (ef.idGrupoMuscular = gm.idGrupoMuscular)");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterExercicoFisicoByID(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * from feminina.exerciciofisico WHERE idExercicioFisico = :idExercicioFisico");
        $stmt->bindValue(":idExercicioFisico",$this->getIdExercicioFisico(),\PDO::PARAM_INT);
        $stmt->execute();
        $dado = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->setDescricao($dado['descricao']);
    }

    public function verificarVinculo(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.exerciciofisico ef 
                                      JOIN feminina.grupomuscular gm ON(gm.idGrupoMuscular = ef.idGrupoMuscular)
                                      WHERE ef.idExercicioFisico = :exercicioFisico AND gm.idGrupoMuscular = :grupoMuscular");
        $stmt->bindValue(":exercicioFisico",$this->getIdExercicioFisico(),\PDO::PARAM_INT);
        $stmt->bindValue(":grupoMuscular",$this->getGrupoMuscular()->getIdGrupoMuscular(),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function verificaExercicioCadastrado(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.exerciciofisico WHERE descricao = :descricao");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function gravar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.exerciciofisico (descricao) VALUES (:descricao)");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obterTodosExerciciosFisicos(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.exerciciofisico");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function criarVinculo(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.exerciciofisico SET idGrupoMuscular = :idGrupoMuscular WHERE idExercicioFisico = :idExercicioFisico");
        $stmt->bindValue(":idGrupoMuscular",$this->getGrupoMuscular()->getIdGrupoMuscular(),\PDO::PARAM_INT);
        $stmt->bindValue(":idExercicioFisico",$this->getIdExercicioFisico(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function desvincularGrupoMuscular(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.exerciciofisico SET idGrupoMuscular = :idGrupoMuscular WHERE idExercicioFisico = :idExercicioFisico");
        $stmt->bindValue(":idGrupoMuscular",null,\PDO::PARAM_NULL);
        $stmt->bindValue(":idExercicioFisico",$this->getIdExercicioFisico(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterExerciciosFisicosPorGrupoMuscular(?\PDO $conn,$naoListar)
    {
        $criterio = "";
        if(!empty($naoListar))
        {
            $naoListar = implode(",",$naoListar);
            $criterio .= " AND idExercicioFisico NOT IN ($naoListar)";
        }
        $sql = "SELECT * FROM feminina.exerciciofisico WHERE idGrupoMuscular = :idGrupoMuscular $criterio";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":idGrupoMuscular",$this->grupoMuscular->getIdGrupoMuscular(),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterTodosExerciciosFisicosPorAluno(?\PDO $conn, mixed $idAluno)
    {
        try{
            $sql = "SELECT gm.descricao AS grupo,ef.descricao AS exercicio,the.series,the.repeticoes,the.peso,the.dia,DATE_FORMAT(ct.dataContrato,'%d/%m/%Y') AS dataContrato,ct.idContrato FROM feminina.aluno al
                    JOIN feminina.contrato ct ON (ct.idAluno = al.idAluno)
                    JOIN feminina.treino tr ON (tr.idContrato = ct.idContrato)
                    LEFT JOIN feminina.treino_has_exerciciofisico the ON (the.Treino_idTreino = tr.idTreino)
                    LEFT JOIN feminina.exerciciofisico ef ON (ef.idExercicioFisico = the.ExercicioFisico_idExercicioFisico)
                    LEFT JOIN feminina.grupomuscular gm ON (gm.idGrupoMuscular = ef.idGrupoMuscular)
                    WHERE al.idAluno = :idAluno
                    ORDER BY data desc,gm.idGrupoMuscular asc";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":idAluno",$idAluno,\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }
}