<?php

namespace App\Dashboard\Repository;

use Config\Connection;

class DashboardRepository
{
    private \PDO $connection;
    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getQuantidadeAlunosContratoAtivo()
    {
        try{
            $stmt = $this->conn->prepare("SELECT COUNT(1) AS quantidadeContratoAtivo FROM feminina.contrato WHERE dataCancelamento IS null");
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }

    public function getAgendamentosHoje()
    {
        try{
            $stmt = $this->conn->prepare("SELECT COUNT(1)  AS quantidadeAvaliacoes FROM feminina.agendamentosavaliacaofisica WHERE DATE(START) = DATE(NOW())");
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }

    public function getQuantidadeAlunos()
    {
        try{
            $stmt = $this->conn->prepare("SELECT COUNT(1) as quantidadeAluno FROM feminina.aluno");
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }

    public function getMensalidadesAtraso()
    {
        try{
            $stmt = $this->conn->prepare("SELECT COUNT(1) as mensalidadeAtraso FROM feminina.mensalidadeatraso");
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_COLUMN);
        }catch (\PDOException $e)
        {

        }
    }
}