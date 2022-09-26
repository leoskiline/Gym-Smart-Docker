<?php

namespace App\Administrador\Model;

use App\Utils\Moeda;
use PDO;

class Administrador
{
    private $idAdministrador;
    private $nome;
    private $salario;
    private $dataNascimento;
    private $sexo;
    private $estadoCivil;
    private $rua;
    private $nrcasa;
    private $bairro;
    private $cidade;
    private $uf;
    private $pais;
    private $cep;
    private $contato;
    private $email;

    /**
     * @param $idAdministrador
     * @param $nome
     * @param $salario
     * @param $dataNascimento
     * @param $sexo
     * @param $estadoCivil
     * @param $rua
     * @param $nrcasa
     * @param $bairro
     * @param $cidade
     * @param $uf
     * @param $pais
     * @param $cep
     * @param $contato
     * @param $email
     */
    public function __construct($idAdministrador, $nome, $salario, $dataNascimento, $sexo, $estadoCivil, $rua, $nrcasa, $bairro, $cidade, $uf, $pais, $cep, $contato, $email)
    {
        $this->idAdministrador = $idAdministrador;
        $this->nome = $nome;
        $this->salario = $salario;
        $this->dataNascimento = $dataNascimento;
        $this->sexo = $sexo;
        $this->estadoCivil = $estadoCivil;
        $this->rua = $rua;
        $this->nrcasa = $nrcasa;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->pais = $pais;
        $this->cep = $cep;
        $this->contato = $contato;
        $this->email = $email;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * @param mixed $salario
     */
    public function setSalario($salario): void
    {
        $this->salario = $salario;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo): void
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * @param mixed $estadoCivil
     */
    public function setEstadoCivil($estadoCivil): void
    {
        $this->estadoCivil = $estadoCivil;
    }

    /**
     * @return mixed
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * @param mixed $rua
     */
    public function setRua($rua): void
    {
        $this->rua = $rua;
    }

    /**
     * @return mixed
     */
    public function getNrcasa()
    {
        return $this->nrcasa;
    }

    /**
     * @param mixed $nrcasa
     */
    public function setNrcasa($nrcasa): void
    {
        $this->nrcasa = $nrcasa;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf): void
    {
        $this->uf = $uf;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais): void
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * @param mixed $contato
     */
    public function setContato($contato): void
    {
        $this->contato = $contato;
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




    public function gravar(PDO $conn)
    {
        try{
            $stmt = $conn->prepare("INSERT INTO feminina.administrador (nome,salario,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email)
                                          VALUES (:nome,:salario,:dataNascimento,:sexo,:estadoCivil,:rua,:nrcasa,:bairro,:cidade,:uf,:pais,:cep,:contato,:email)");
            $stmt->bindValue(":nome",$this->getNome(),\PDO::PARAM_STR);
            $stmt->bindValue(":salario",Moeda::MoedaDB($this->getSalario()),\PDO::PARAM_STR);
            $stmt->bindValue(":dataNascimento",$this->getDataNascimento(),\PDO::PARAM_STR);
            $stmt->bindValue(":sexo",$this->getSexo(),\PDO::PARAM_STR);
            $stmt->bindValue(":estadoCivil",$this->getEstadoCivil(),\PDO::PARAM_STR);
            $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
            $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_STR);
            $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
            $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
            $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
            $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
            $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
            $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
            $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
            if($stmt->execute())
            {
                $this->setIdAdministrador($conn->lastInsertId());
                return true;
            }
            else{
                return false;
            }
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterAdministradorById(?PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT * FROM feminina.administrador WHERE idAdministrador = :idAdministrador");
            $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::PARAM_INT);
            $this->setEmail($dados['email']);
            $this->setNome($dados['nome']);
            $this->setSalario($dados['salario']);
            $this->setDataNascimento($dados['dataNascimento']);
            $this->setSexo($dados['sexo']);
            $this->setEstadoCivil($dados['estadoCivil']);
            $this->setRua($dados['rua']);
            $this->setNrcasa($dados['nrcasa']);
            $this->setBairro($dados['bairro']);
            $this->setCidade($dados['cidade']);
            $this->setUf($dados['uf']);
            $this->setPais($dados['pais']);
            $this->setCep($dados['cep']);
            $this->setContato($dados['contato']);
            $this->setEmail($dados['email']);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function obterTodosAdministradores(?PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idAdministrador,nome,salario,DATE_FORMAT(dataNascimento, '%d/%m/%Y') as dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email FROM feminina.administrador");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function atualizarUsuario(?PDO $conn, mixed $senha)
    {
        $stmt = $conn->prepare("UPDATE feminina.usuario SET email = :email, senha = :senha WHERE idAdministrador = :idAdministrador");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":senha",$senha,\PDO::PARAM_STR);
        $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizarAdministrador(?PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.administrador SET nome = :nome,salario = :salario,dataNascimento = :dataNascimento,sexo = :sexo,estadoCivil = :estadoCivil,
                          rua = :rua,nrcasa = :nrcasa,bairro = :bairro,cidade = :cidade,uf = :uf,pais = :pais,cep = :cep,contato = :contato,email = :email 
                          WHERE idAdministrador = :idAdministrador");
        $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
        $stmt->bindValue(":salario",$this->getSalario(),\PDO::PARAM_STR);
        $stmt->bindValue(":nome",$this->getNome(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataNascimento",$this->getDataNascimento(),\PDO::PARAM_STR);
        $stmt->bindValue(":sexo",$this->getSexo(),\PDO::PARAM_STR);
        $stmt->bindValue(":estadoCivil",$this->getEstadoCivil(),\PDO::PARAM_STR);
        $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
        $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_STR);
        $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
        $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
        $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
        $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
        $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obtemEmailCadastrado(?PDO $conn)
    {
        $stmt = $conn->prepare("SELECT adm.email,adm.nome FROM feminina.administrador adm 
                                       JOIN feminina.usuario usu ON (usu.idAdministrador = adm.idAdministrador) 
                                      WHERE adm.email = :email AND usu.usuarioAtivo = 1");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->execute();
        $administrador = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt = $conn->prepare("SELECT prof.email,prof.nome FROM feminina.professor prof
                                       JOIN feminina.usuario usu ON (usu.idProfessor = prof.idProfessor) 
                                      WHERE prof.email = :email AND usu.usuarioAtivo = 1");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->execute();
        $professor = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt = $conn->prepare("SELECT ins.email,ins.nome FROM feminina.instrutor ins
                                        JOIN feminina.usuario usu ON (usu.idInstrutor = ins.idInstrutor)
                                        WHERE ins.email = :email AND usu.usuarioAtivo = 1");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->execute();
        $instrutor = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [$administrador,$professor,$instrutor];
    }

    public function gravarAdministrador(?PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.administrador (nome,salario,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email) VALUES (:nome,:salario,:dataNascimento,:sexo,:estadoCivil,:rua,:nrcasa,:bairro,:cidade,:uf,:pais,:cep,:contato,:email)");
        $stmt->bindValue(":nome",$this->getNome(),\PDO::PARAM_STR);
        $stmt->bindValue(":salario",$this->getSalario(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataNascimento",$this->getDataNascimento(),\PDO::PARAM_STR);
        $stmt->bindValue(":sexo",$this->getSexo(),\PDO::PARAM_STR);
        $stmt->bindValue(":estadoCivil",$this->getEstadoCivil(),\PDO::PARAM_STR);
        $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
        $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_STR);
        $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
        $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
        $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
        $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
        $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->execute();
        return $conn->lastInsertId();
    }

    public function gravarUsuario(?PDO $conn, mixed $senha)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.usuario (nivel,email,senha,dataCadastro,usuarioAtivo,idAdministrador) VALUES (:nivel,:email,:senha,:dataCadastro,:usuarioAtivo,:idAdministrador)");
        $stmt->bindValue(":nivel","Administrador",\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":senha",$senha,\PDO::PARAM_STR);
        $stmt->bindValue(":dataCadastro",date("Y-m-d"),\PDO::PARAM_STR);
        $stmt->bindValue(":usuarioAtivo",1,\PDO::PARAM_INT);
        $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deletarById(?PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.administrador WHERE idAdministrador = :idAdministrador");
        $stmt->bindValue(":idAdministrador",$this->getIdAdministrador(),\PDO::PARAM_INT);
        return $stmt->execute();
    }


}