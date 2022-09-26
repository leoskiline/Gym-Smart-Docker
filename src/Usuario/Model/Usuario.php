<?php

namespace App\Usuario\Model;

use App\Administrador\Model\Administrador;
use App\Instrutor\Model\Instrutor;
use App\Professor\Model\Professor;
use Config\Connection;
use PDO;

class Usuario
{
    private $idUsuario;
    private $nivel;
    private $email;
    private $senha;
    private $dataCadastro;
    private $usuarioAtivo;
    private $administrador;
    private $professor;
    private $instrutor;

    /**
     * @param $idUsuario
     * @param $nivel
     * @param $email
     * @param $senha
     * @param $dataCadastro
     * @param $usuarioAtivo
     * @param $administrador
     * @param $professor
     * @param $instrutor
     */
    public function __construct($idUsuario, $nivel, $email, $senha, $dataCadastro, $usuarioAtivo, $administrador, $professor, $instrutor)
    {
        $this->idUsuario = $idUsuario;
        $this->nivel = $nivel;
        $this->email = $email;
        $this->senha = $senha;
        $this->dataCadastro = $dataCadastro;
        $this->usuarioAtivo = $usuarioAtivo;
        $this->administrador = $administrador;
        $this->professor = $professor;
        $this->instrutor = $instrutor;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     */
    public function setNivel($nivel): void
    {
        $this->nivel = $nivel;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha): void
    {
        $this->senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * @param mixed $dataCadastro
     */
    public function setDataCadastro($dataCadastro): void
    {
        $this->dataCadastro = $dataCadastro;
    }

    /**
     * @return mixed
     */
    public function getUsuarioAtivo()
    {
        return $this->usuarioAtivo;
    }

    /**
     * @param mixed $usuarioAtivo
     */
    public function setUsuarioAtivo($usuarioAtivo): void
    {
        $this->usuarioAtivo = $usuarioAtivo;
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
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param mixed $professor
     */
    public function setProfessor($professor): void
    {
        $this->professor = $professor;
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

    public function getUsuarioLogin(PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.usuario WHERE email = :email AND senha = :senha");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":senha",$this->getSenha(),\PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount())
        {
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->setIdUsuario($usuario['idUsuario']);
            $this->setNivel($usuario['nivel']);
            $this->setEmail($usuario['email']);
            $this->setSenha($usuario['senha']);
            $this->setDataCadastro($usuario['dataCadastro']);
            $this->setUsuarioAtivo($usuario['usuarioAtivo']);
            $this->setAdministrador($usuario['idAdministrador']);
            $this->setProfessor($usuario['idProfessor']);
            $this->setInstrutor($usuario['idInstrutor']);
            if(!empty($this->getAdministrador()))
            {
                $administrador = new Administrador($this->getAdministrador(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $administrador->obterAdministradorById($conn);
                $this->setAdministrador($administrador);
            }
            if(!empty($this->getProfessor()))
            {
                $professor = new Professor($this->getProfessor(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $professor->obterProfessorById($conn);
                $this->setProfessor($professor);
            }
            if(!empty($this->getInstrutor()))
            {
                $instrutor = new Instrutor($this->getInstrutor(),null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $instrutor->obterInstrutorById($conn);
                $this->setInstrutor($instrutor);
            }
        }
    }

    public function gravar(PDO $conn)
    {
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.usuario (nivel,email,senha,dataCadastro,usuarioAtivo,idAdministrador,idProfessor,idInstrutor)
                                          VALUES (:nivel,:email,:senha,:dataCadastro,:usuarioAtivo,:idAdministrador,:idProfessor,:idInstrutor)");
            $stmt->bindValue(":nivel",$this->getNivel(),\PDO::PARAM_STR);
            $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
            $stmt->bindValue(":senha",$this->getSenha(),\PDO::PARAM_STR);
            $stmt->bindValue(":dataCadastro",$this->getDataCadastro(),\PDO::PARAM_STR);
            $stmt->bindValue(":usuarioAtivo",$this->getUsuarioAtivo(),\PDO::PARAM_INT);
            $stmt->bindValue(":idAdministrador",$this->getAdministrador() ? $this->getAdministrador()->getIdAdministrador() : null,\PDO::PARAM_INT);
            $stmt->bindValue(":idProfessor",$this->getProfessor() ? $this->getProfessor()->getIdProfessor() : null,\PDO::PARAM_INT);
            $stmt->bindValue(":idInstrutor",$this->getInstrutor() ? $this->getInstrutor()->getIdInstrutor() : null,\PDO::PARAM_INT);
            if($stmt->execute())
            {
                $this->setIdUsuario($conn->lastInsertId());
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterAvaliadores(?PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT u.idUsuario,
                                                if(u.idAdministrador is not null,a.nome,if(u.idInstrutor is not null,i.nome,if(u.idProfessor is not null,p.nome,''))) as nome,
                                                u.nivel,
                                                u.usuarioAtivo,
                                                u.idAdministrador,
                                                u.idProfessor,
                                                u.idInstrutor FROM feminina.usuario u 
                                                left join feminina.administrador a on (a.idAdministrador = u.idAdministrador)
                                                left join feminina.instrutor i on (i.idInstrutor = u.idInstrutor)
                                                left join feminina.professor p on (p.idProfessor = u.idProfessor)
                                                where (u.idAdministrador is not null or u.idProfessor is not null or u.idInstrutor is not null) and usuarioAtivo = 1;");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterUsuarioById(?PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT * FROM feminina.usuario WHERE idUsuario = :idUsuario");
            $stmt->bindValue(":idUsuario",$this->idUsuario,\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->setEmail($dados['email']);
            $this->setInstrutor($dados['idInstrutor']);
            $this->setProfessor($dados['idProfessor']);
            $this->setAdministrador($dados['idAdministrador']);
            $this->setUsuarioAtivo($dados['usuarioAtivo']);
            $this->setDataCadastro($dados['dataCadastro']);
            $this->setNivel($dados['nivel']);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function deletarByIdAdministrador(?PDO $conn)
    {
        try{
            $stmt = $conn->prepare("DELETE FROM feminina.usuario WHERE idAdministrador = :idAdministrador");
            $stmt->bindValue(":idAdministrador",$this->getAdministrador()->getIdAdministrador(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }
}