<?php

namespace App\Aluno\Model;

class Aluno
{
    private $idAluno;
    private $idUsuario;
    private $nome;
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
    private $cpf;

    /**
     * @param $idAluno
     * @param $idUsuario
     * @param $nome
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
     * @param $cpf
     */
    public function __construct($idAluno, $idUsuario, $nome, $dataNascimento, $sexo, $estadoCivil, $rua, $nrcasa, $bairro, $cidade, $uf, $pais, $cep, $contato, $email, $cpf)
    {
        $this->idAluno = $idAluno;
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
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
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getIdAluno()
    {
        return $this->idAluno;
    }

    /**
     * @param mixed $idAluno
     */
    public function setIdAluno($idAluno): void
    {
        $this->idAluno = $idAluno;
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

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }


    private function criterioUpdate()
    {
        $criterio = "";
        if(!empty($this->getIdAluno()))
        {
            $criterio = " AND idAluno <> :idAluno";
        }
        return $criterio;
    }

    public function obterAlunoPorCPF(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idAluno, idUsuario, nome, dataNascimento, sexo, estadoCivil, rua, nrcasa, bairro, cidade, uf, pais, cep, contato, email, cpf FROM feminina.aluno WHERE cpf = :cpf {$this->criterioUpdate()}");
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        if(!empty($this->getIdAluno()))
        {
            $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
        }
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setIdAluno($dados['idAluno']);
            $this->setIdUsuario($dados['idUsuario']);
            $this->setNome($dados['nome']);
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
            $this->setCpf($dados['cpf']);
        }else{
            $this->setIdAluno(null);
        }
    }

    public function gravarAluno(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.aluno (idUsuario,nome,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email,cpf) VALUES (:idUsuario,:nome,:dataNascimento,:sexo,:estadoCivil,:rua,:nrcasa,:bairro,:cidade,:uf,:pais,:cep,:contato,:email,:cpf)");
        $stmt->bindValue(":idUsuario",$this->getIdUsuario(),\PDO::PARAM_INT);
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
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deletarAluno(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.aluno WHERE idAluno = :idAluno");
        $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterAlunoPorId(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.aluno where idAluno = :idAluno");
        $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setIdAluno($dados['idAluno']);
            $this->setIdUsuario($dados['idUsuario']);
            $this->setNome($dados['nome']);
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
            $this->setCpf($dados['cpf']);
        }
        else{
            $this->setIdAluno(null);
        }

    }

    public function atualizarAluno(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.aluno SET idUsuario = :idUsuario,nome = :nome,dataNascimento = :dataNascimento,sexo = :sexo,estadoCivil = :estadoCivil,
                          rua = :rua,nrcasa = :nrcasa,bairro = :bairro,cidade = :cidade,uf = :uf,pais = :pais,cep = :cep,contato = :contato,email = :email,cpf = :cpf 
                          WHERE idAluno = :idAluno");
        $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
        $stmt->bindValue(":idUsuario",$this->getIdUsuario(),\PDO::PARAM_INT);
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
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obterTodosAlunos(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idAluno,idUsuario,nome,DATE_FORMAT(dataNascimento, '%d/%m/%Y') as dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email,cpf FROM feminina.aluno");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterAlunoPorEmail(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.aluno where email = :email {$this->criterioUpdate()}");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        if(!empty($this->getIdAluno()))
        {
            $stmt->bindValue(":idAluno",$this->getIdAluno(),\PDO::PARAM_INT);
        }
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setIdAluno($dados['idAluno']);
            $this->setIdUsuario($dados['idUsuario']);
            $this->setNome($dados['nome']);
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
            $this->setTelefone($dados['telefone']);
            $this->setEmail($dados['email']);
            $this->setCelular($dados['celular']);
            $this->setCpf($dados['cpf']);
        }
        else{
            $this->setIdAluno(null);
        }
    }

    public function obterAlunosPossuemExericicios(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT al.idAluno,al.nome
						  FROM feminina.aluno al
                    JOIN feminina.contrato ct ON (ct.idAluno = al.idAluno)
                    JOIN feminina.treino tr ON (tr.idContrato = ct.idContrato)
                    LEFT JOIN feminina.treino_has_exerciciofisico the ON (the.Treino_idTreino = tr.idTreino)
                    LEFT JOIN feminina.exerciciofisico ef ON (ef.idExercicioFisico = the.ExercicioFisico_idExercicioFisico)
                    LEFT JOIN feminina.grupomuscular gm ON (gm.idGrupoMuscular = ef.idGrupoMuscular)
                    GROUP BY al.idAluno");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {

        }
    }
}