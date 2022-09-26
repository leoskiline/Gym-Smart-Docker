<?php

namespace App\AgendamentoAvaliacao\Model;

class AgendamentoAvaliacao
{
    private $idAgendamentoAvaliacaoFisica;
    private $idInstrutor;
    private $idAdministrador;
    private $idProfessor;
    private $idAluno;
    private $tipoAvaliacao;
    private $start;
    private $end;
    private $title;
    private $color;
    private $valor;

    /**
     * @param $idAgendamentoAvaliacaoFisica
     * @param $idInstrutor
     * @param $idAdministrador
     * @param $idProfessor
     * @param $idMatricula
     * @param $tipoAvaliacao
     * @param $start
     * @param $end
     * @param $title
     * @param $color
     * @param $valor
     */
    public function __construct($idAgendamentoAvaliacaoFisica, $idInstrutor, $idAdministrador, $idProfessor, $idAluno, $tipoAvaliacao, $start, $end, $title, $color, $valor)
    {
        $this->idAgendamentoAvaliacaoFisica = $idAgendamentoAvaliacaoFisica;
        $this->idInstrutor = $idInstrutor;
        $this->idAdministrador = $idAdministrador;
        $this->idProfessor = $idProfessor;
        $this->idAluno = $idAluno;
        $this->tipoAvaliacao = $tipoAvaliacao;
        $this->start = $start;
        $this->end = $end;
        $this->title = $title;
        $this->color = $color;
        $this->valor = $valor;
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
    public function getIdInstrutor()
    {
        return $this->idInstrutor;
    }

    /**
     * @param mixed $idInstrutor
     */
    public function setIdInstrutor($idInstrutor): void
    {
        $this->idInstrutor = $idInstrutor;
    }

    /**
     * @return mixed
     */
    public function getIdAdministrador()
    {
        return $this->idAdministrador;
    }

    /**
     * @param mixed $idAdministrador
     */
    public function setIdAdministrador($idAdministrador): void
    {
        $this->idAdministrador = $idAdministrador;
    }

    /**
     * @return mixed
     */
    public function getIdProfessor()
    {
        return $this->idProfessor;
    }

    /**
     * @param mixed $idProfessor
     */
    public function setIdProfessor($idProfessor): void
    {
        $this->idProfessor = $idProfessor;
    }

    /**
     * @return mixed
     */
    public function getIdAluno()
    {
        return $this->idAluno;
    }

    /**
     * @param mixed $idMatricula
     */
    public function setIdAluno($idAluno): void
    {
        $this->idAluno = $idAluno;
    }

    /**
     * @return mixed
     */
    public function getTipoAvaliacao()
    {
        return $this->tipoAvaliacao;
    }

    /**
     * @param mixed $tipoAvaliacao
     */
    public function setTipoAvaliacao($tipoAvaliacao): void
    {
        $this->tipoAvaliacao = $tipoAvaliacao;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end): void
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
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

    public function gravarAgendamento(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.agendamentosavaliacaofisica 
            (idInstrutor, idAdministrador, idProfessor, idAluno, tipoAvaliacao, start,end,title,color, valor) 
                VALUES (:idInstrutor,:idAdministrador,:idProfessor,:idAluno,:tipoAvaliacao,:start,:end,:title,:color,:valor)");
            $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
            $stmt->bindValue(":idProfessor",$this->getIdProfessor(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
            $stmt->bindValue(":tipoAvaliacao",$this->getTipoAvaliacao(),\PDO::PARAM_STR);
            $stmt->bindValue(":start",$this->getStart(),\PDO::PARAM_STR);
            $stmt->bindValue(":end",$this->getEnd(),\PDO::PARAM_STR);
            $stmt->bindValue(":title",$this->getTitle(),\PDO::PARAM_STR);
            $stmt->bindValue(":color",$this->getColor(),\PDO::PARAM_STR);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            $exec = $stmt->execute();
            $this->setIdAgendamentoAvaliacaoFisica($conn->lastInsertId());
            return $exec;
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterTodosAgendamentos(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT 
                                            if(aaf.idAdministrador is not null, usua.idUsuario,if(aaf.idInstrutor is not null, usui.idUsuario, if(aaf.idProfessor is not null,usup.idUsuario,null))) as idAvaliador,
                                            if(aaf.idAdministrador is not null, adm.nome,if(aaf.idInstrutor is not null, ins.nome, if(aaf.idProfessor is not null,prof.nome,null))) as nomeAvaliador,
                                            al.idAluno,al.nome as nomeAluno,aaf.idAgendamentoAvaliacaoFisica,aaf.tipoAvaliacao,aaf.start,aaf.end,aaf.title,aaf.color,aaf.valor
                                        FROM feminina.agendamentosavaliacaofisica aaf
                                        join feminina.aluno al on (al.idAluno = aaf.idAluno)
                                        left join feminina.usuario usua on (usua.idAdministrador = aaf.idAdministrador)
                                        left join feminina.usuario usui on (usui.idInstrutor = aaf.idInstrutor)
                                        left join feminina.usuario usup on (usup.idProfessor = aaf.idProfessor)
                                        left join feminina.instrutor ins on (ins.idInstrutor = aaf.idInstrutor)
                                        left join feminina.professor prof on (prof.idProfessor = aaf.idProfessor)
                                        left join feminina.administrador adm on (adm.idAdministrador = aaf.idAdministrador)");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function deletarById(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("DELETE FROM feminina.agendamentosavaliacaofisica where idAgendamentoAvaliacaoFisica = :idAgendamentoAvaliacaoFisica");
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function atualizar(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.agendamentosavaliacaofisica SET idInstrutor = :idInstrutor, idAdministrador = :idAdministrador, idProfessor = :idProfessor,
                                         idAluno = :idAluno, tipoAvaliacao = :tipoAvaliacao, start = :start, end = :end, title = :title, color = :color, valor = :valor 
                                         WHERE idAgendamentoAvaliacaoFisica = :idAgendamentoAvaliacaoFisica");
            $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
            $stmt->bindValue(":idProfessor",$this->getIdProfessor(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
            $stmt->bindValue(":tipoAvaliacao",$this->getTipoAvaliacao(),\PDO::PARAM_STR);
            $stmt->bindValue(":start",$this->getStart(),\PDO::PARAM_STR);
            $stmt->bindValue(":end",$this->getEnd(),\PDO::PARAM_STR);
            $stmt->bindValue(":title",$this->getTitle(),\PDO::PARAM_STR);
            $stmt->bindValue(":color",$this->getColor(),\PDO::PARAM_STR);
            $stmt->bindValue(":valor",$this->getValor(),\PDO::PARAM_STR);
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    private function queryProfissional()
    {
        $query = true;
        if(!empty($this->getIdInstrutor()))
        {
            $query = "idInstrutor = :idInstrutor";
        }else if(!empty($this->getIdProfessor()))
        {
            $query = "idProfessor = :idProfessor";
        }else if(!empty($this->getIdAdministrador()))
        {
            $query = "idAdministrador = :idAdministrador";
        }
        return $query;
    }

    private function bindProfissional(?\PDOStatement $stmt)
    {
        if(!empty($this->getIdInstrutor()))
        {
            $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        }else if(!empty($this->getIdProfessor()))
        {
            $stmt->bindValue(":idProfessor",$this->getIdProfessor(),\PDO::PARAM_INT);
        }else if(!empty($this->getIdAdministrador()))
        {
            $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
        }
    }

    public function verificarAvaliadorDisponivel(?\PDO $conn)
    {
        try{
            $sql = "SELECT * FROM feminina.agendamentosavaliacaofisica WHERE ((start between :start1 and :end1) OR (end between :start2 and :end2)) AND {$this->queryProfissional()} {$this->queryAtualizar()}";
            $stmt = $conn->prepare($sql);
            $this->bindProfissional($stmt);
            $this->bindAtualizar($stmt);
            $stmt->bindValue(":start1",$this->getStart(),\PDO::PARAM_STR);
            $stmt->bindValue(":end1",$this->getEnd(),\PDO::PARAM_STR);
            $stmt->bindValue(":start2",$this->getStart(),\PDO::PARAM_STR);
            $stmt->bindValue(":end2",$this->getEnd(),\PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function verificarAgendadoDia(?\PDO $conn)
    {
        try{
            $sql = "SELECT * FROM feminina.agendamentosavaliacaofisica WHERE ((date_format(start,'%Y-%m-%d') between :start1 and :end1) OR (date_format(end,'%Y-%m-%d') between :start2 and :end2)) AND idAluno = :idAluno";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":start1",explode(" ",$this->getStart())[0],\PDO::PARAM_STR);
            $stmt->bindValue(":end1",explode(" ",$this->getEnd())[0],\PDO::PARAM_STR);
            $stmt->bindValue(":start2",explode(" ",$this->getStart())[0],\PDO::PARAM_STR);
            $stmt->bindValue(":end2",explode(" ",$this->getEnd())[0],\PDO::PARAM_STR);
            $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    private function queryAtualizar()
    {
        $sql = "";
        if(!empty($this->getIdAgendamentoAvaliacaoFisica()))
        {
            $sql = " AND idAgendamentoAvaliacaoFisica <> :idAgendamentoAvaliacaoFisica";
        }
        return $sql;
    }

    private function bindAtualizar(bool|\PDOStatement $stmt)
    {
        if(!empty($this->getIdAgendamentoAvaliacaoFisica()))
        {
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
        }
    }

    private function verificarAvaliador($avaliador,?\PDO $conn)
    {
        $criterio = "";
        $idAvaliador = "";
        try{
            $stmt = $conn->prepare("SELECT idUsuario,nivel,email,dataCadastro,usuarioAtivo,idAdministrador,idProfessor,idInstrutor from feminina.usuario WHERE idUsuario = :idUsuario");
            $stmt->bindValue(":idUsuario",$avaliador,\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($dados)
            {
                !empty($dados['idAdministrador']) ? $criterio .= " AND aaf.idAdministrador = :filterAvaliador" : $criterio .= "";
                !empty($dados['idProfessor']) ? $criterio .= " AND aaf.idProfessor = :filterAvaliador" : $criterio .= "";
                !empty($dados['idInstrutor']) ? $criterio .= " AND aaf.idInstrutor = :filterAvaliador" : $criterio .= "";
                if(!empty($dados['idAdministrador']))
                {
                    $idAvaliador = $dados['idAdministrador'];
                }
                if(!empty($dados['idProfessor']))
                {
                    $idAvaliador = $dados['idProfessor'];
                }
                if(!empty($dados['idInstrutor']))
                {
                    $idAvaliador = $dados['idInstrutor'];
                }
            }
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
        return [$criterio, $idAvaliador];
    }

    public function obterAgendamentosFiltrados(?\PDO $conn, object|array|null $dados)
    {
        try{
            $criteiro = "";
            $criterios = $this->verificarAvaliador($dados['filterAvaliador'],$conn);
            !empty($dados['filterAluno']) ? $criteiro .= " AND aaf.idAluno = :filterAluno" : $criteiro .= "";
            !empty($dados['filterAvaliador']) ? $criteiro .= $criterios[0] : $criteiro .= "";
            $sql = "SELECT 
                                            if(aaf.idAdministrador is not null, usua.idUsuario,if(aaf.idInstrutor is not null, usui.idUsuario, if(aaf.idProfessor is not null,usup.idUsuario,null))) as idAvaliador,
                                            if(aaf.idAdministrador is not null, adm.nome,if(aaf.idInstrutor is not null, ins.nome, if(aaf.idProfessor is not null,prof.nome,null))) as nomeAvaliador,
                                            al.idAluno,al.nome as nomeAluno,aaf.idAgendamentoAvaliacaoFisica,aaf.tipoAvaliacao,aaf.start,aaf.end,aaf.title,aaf.color,aaf.valor
                                        FROM feminina.agendamentosavaliacaofisica aaf
                                        join feminina.aluno al on (al.idAluno = aaf.idAluno)
                                        left join feminina.usuario usua on (usua.idAdministrador = aaf.idAdministrador)
                                        left join feminina.usuario usui on (usui.idInstrutor = aaf.idInstrutor)
                                        left join feminina.usuario usup on (usup.idProfessor = aaf.idProfessor)
                                        left join feminina.instrutor ins on (ins.idInstrutor = aaf.idInstrutor)
                                        left join feminina.professor prof on (prof.idProfessor = aaf.idProfessor)
                                        left join feminina.administrador adm on (adm.idAdministrador = aaf.idAdministrador)
                                        WHERE true {$criteiro}";
            $stmt = $conn->prepare($sql);
            if(strpos($criteiro,"idAluno"))
                $stmt->bindValue(":filterAluno",$dados['filterAluno'],\PDO::PARAM_INT);
            if(strpos($criteiro,"idAdministrador") || strpos($criteiro,"idProfessor") || strpos($criteiro,"idInstrutor"))
                $stmt->bindValue(":filterAvaliador",$criterios[1],\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterTodosAgendamentosDiaAtual(?\PDO $conn)
    {
        try{
            $conn->query("SET @@global.time_zone = '+03:00';");
            $stmt = $conn->prepare("SELECT aaf.*
                                            FROM feminina.agendamentosavaliacaofisica aaf
                                            LEFT JOIN feminina.avaliacaofisica af ON (af.idAgendamentoAvaliacaoFisica = aaf.idAgendamentoAvaliacaoFisica)
                                            WHERE convert(START,DATE) = CURDATE() AND convert(START,TIME) >= CURTIME() AND af.idAvaliacaoFisica IS NULL");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }

    public function obterAgendamentoPorId(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idAgendamentoAvaliacaoFisica, idInstrutor, idAdministrador, idProfessor, idAluno, tipoAvaliacao, start, end, title, color, valor FROM feminina.agendamentosavaliacaofisica WHERE idAgendamentoAvaliacaoFisica = :idAgendamentoAvaliacaoFisica");
            $stmt->bindValue(":idAgendamentoAvaliacaoFisica",$this->getIdAgendamentoAvaliacaoFisica(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($dados))
            {
                $this->setIdAgendamentoAvaliacaoFisica($dados['idAgendamentoAvaliacaoFisica']);
                $this->setIdInstrutor($dados['idInstrutor']);
                $this->setIdAdministrador($dados['idAdministrador']);
                $this->setIdProfessor($dados['idProfessor']);
                $this->setIdAluno($dados['idAluno']);
                $this->setTipoAvaliacao($dados['tipoAvaliacao']);
                $this->setStart($dados['start']);
                $this->setEnd($dados['end']);
                $this->setTitle($dados['title']);
                $this->setColor($dados['color']);
                $this->setValor($dados['valor']);
            }else{
                $this->setIdAgendamentoAvaliacaoFisica(null);
            }
        }catch (\PDOException $e)
        {

        }
    }

}