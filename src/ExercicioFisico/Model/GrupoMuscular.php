<?php

namespace App\ExercicioFisico\Model;

class GrupoMuscular
{
    private $idGrupoMuscular;
    private $descricao;

    /**
     * @param $idGrupoMuscular
     * @param $descricao
     */
    public function __construct($idGrupoMuscular, $descricao)
    {
        $this->idGrupoMuscular = $idGrupoMuscular;
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getIdGrupoMuscular()
    {
        return $this->idGrupoMuscular;
    }

    /**
     * @param mixed $idGrupoMuscular
     */
    public function setIdGrupoMuscular($idGrupoMuscular): void
    {
        $this->idGrupoMuscular = $idGrupoMuscular;
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

    public function obterGrupoMuscularByID(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.grupomuscular WHERE idGrupoMuscular = :idGrupoMuscular");
        $stmt->bindValue(":idGrupoMuscular",$this->getIdGrupoMuscular(),\PDO::PARAM_INT);
        $stmt->execute();
        $dado = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->setDescricao($dado['descricao']);
    }

    public function verificaCadastrado(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.grupomuscular WHERE descricao = :descricao");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function gravar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.grupomuscular (descricao) VALUES (:descricao)");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obterTodosGruposMusculares(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.grupomuscular");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}