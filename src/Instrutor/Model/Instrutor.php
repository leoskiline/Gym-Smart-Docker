<?php

namespace App\Instrutor\Model;

class Instrutor
{
    private $idInstrutor;
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
    private $rg;
    private $cpf;
    private $dataAdmissao;
    private $dataDemissao;

    /**
     * @param $idInstrutor
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
     * @param $rg
     * @param $cpf
     * @param $dataAdmissao
     * @param $dataDemissao
     */
    public function __construct($idInstrutor, $nome, $salario, $dataNascimento, $sexo, $estadoCivil, $rua, $nrcasa, $bairro, $cidade, $uf, $pais, $cep, $contato, $email, $rg, $cpf, $dataAdmissao, $dataDemissao)
    {
        $this->idInstrutor = $idInstrutor;
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
        $this->rg = $rg;
        $this->cpf = $cpf;
        $this->dataAdmissao = $dataAdmissao;
        $this->dataDemissao = $dataDemissao;
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

    /**
     * @return mixed
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @param mixed $rg
     */
    public function setRg($rg): void
    {
        $this->rg = $rg;
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

    /**
     * @return mixed
     */
    public function getDataAdmissao()
    {
        return $this->dataAdmissao;
    }

    /**
     * @param mixed $dataAdmissao
     */
    public function setDataAdmissao($dataAdmissao): void
    {
        $this->dataAdmissao = $dataAdmissao;
    }

    /**
     * @return mixed
     */
    public function getDataDemissao()
    {
        return $this->dataDemissao;
    }

    /**
     * @param mixed $dataDemissao
     */
    public function setDataDemissao($dataDemissao): void
    {
        $this->dataDemissao = $dataDemissao;
    }



    public function obterInstrutorById(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.instrutor WHERE idInstrutor = :idInstrutor");
        $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
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
        $this->setRg($dados['rg']);
        $this->setCpf($dados['cpf']);
        $this->setDataAdmissao($dados['dataAdmissao']);
        $this->setDataDemissao($dados['dataDemissao']);
    }

    public function obterTodosInstrutores(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idInstrutor,nome,salario,DATE_FORMAT(dataNascimento, '%d/%m/%Y') as dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email,rg,cpf,DATE_FORMAT(dataAdmissao, '%d/%m/%Y') as dataAdmissao,dataDemissao FROM feminina.instrutor");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obterInstrutorPorCPF(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT idInstrutor, nome, salario, dataNascimento, sexo, estadoCivil, rua, nrcasa, bairro, cidade, uf, pais, cep, contato, email, rg, cpf, dataAdmissao, dataDemissao FROM feminina.instrutor WHERE cpf = :cpf");
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setIdInstrutor($dados['idInstrutor']);
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
            $this->setRg($dados['rg']);
            $this->setCpf($dados['cpf']);
            $this->setDataAdmissao($dados['dataAdmissao']);
            $this->setDataDemissao($dados['dataDemissao']);
        }
    }

    public function verificarEmailCadastrado(?\PDO $conn)
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

    public function gravar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.instrutor (nome,salario,dataNascimento,sexo,estadoCivil,rua,nrcasa,bairro,cidade,uf,pais,cep,contato,email,rg,cpf,dataAdmissao,dataDemissao) VALUES (:nome,:salario,:dataNascimento,:sexo,:estadoCivil,:rua,:nrcasa,:bairro,:cidade,:uf,:pais,:cep,:contato,:email,:rg,:cpf,:dataAdmissao,:dataDemissao)");
        $stmt->bindValue(":nome",$this->getNome(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataNascimento",$this->getDataNascimento(),\PDO::PARAM_STR);
        $stmt->bindValue(":salario",$this->getSalario(),\PDO::PARAM_STR);
        $stmt->bindValue(":sexo",$this->getSexo(),\PDO::PARAM_STR);
        $stmt->bindValue(":estadoCivil",$this->getEstadoCivil(),\PDO::PARAM_STR);
        $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
        $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_INT);
        $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
        $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
        $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
        $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
        $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",!empty($this->getContato()) ? $this->getContato() : null,\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":rg",$this->getRg(),\PDO::PARAM_STR);
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataAdmissao",$this->getDataAdmissao(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataDemissao",!empty($this->getDataDemissao()) ? $this->getDataDemissao() : null,\PDO::PARAM_STR);
        $stmt->execute();
        $this->setIdInstrutor($conn->lastInsertId());
    }

    public function atualizarUsuario(?\PDO $conn, bool|string $senha)
    {
        $stmt = $conn->prepare("UPDATE feminina.usuario SET email = :email, senha = :senha WHERE idInstrutor = :idInstrutor");
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":senha",$senha,\PDO::PARAM_STR);
        $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.instrutor SET nome = :nome,dataNascimento = :dataNascimento,sexo = :sexo,estadoCivil = :estadoCivil,
                          rua = :rua,bairro = :bairro,cidade = :cidade,uf = :uf,pais = :pais,cep = :cep,contato = :contato,email = :email,rg = :rg,
                           cpf = :cpf, dataAdmissao = :dataAdmissao, dataDemissao = :dataDemissao    
                          WHERE idInstrutor = :idInstrutor");
        $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        $stmt->bindValue(":nome",$this->getNome(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataNascimento",$this->getDataNascimento(),\PDO::PARAM_STR);
        $stmt->bindValue(":sexo",$this->getSexo(),\PDO::PARAM_STR);
        $stmt->bindValue(":estadoCivil",$this->getEstadoCivil(),\PDO::PARAM_STR);
        $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
        $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
        $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
        $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
        $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
        $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",!empty($this->getContato()) ? $this->getContato() : null,\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":rg",$this->getRg(),\PDO::PARAM_STR);
        $stmt->bindValue(":cpf",$this->getCpf(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataAdmissao",$this->getDataAdmissao(),\PDO::PARAM_STR);
        $stmt->bindValue(":dataDemissao",!empty($this->getDataDemissao()) ? $this->getDataDemissao() : null,\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deletar(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.instrutor WHERE idInstrutor = :idInstrutor");
        $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deletarUsuario(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.usuario WHERE idInstrutor = :idInstrutor");
        $stmt->bindValue(":idInstrutor",$this->getIdInstrutor(),\PDO::PARAM_INT);
        return $stmt->execute();
    }


}