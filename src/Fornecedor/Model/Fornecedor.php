<?php

namespace App\Fornecedor\Model;

class Fornecedor
{
    private $idFornecedor;
    private $descricao;
    private $contato;
    private $email;
    private $pessoaContato;

    /**
     * @param $idFornecedor
     * @param $descricao
     * @param $contato
     * @param $email
     * @param $pessoaContato
     */
    public function __construct($idFornecedor, $descricao, $contato, $email, $pessoaContato)
    {
        $this->idFornecedor = $idFornecedor;
        $this->descricao = $descricao;
        $this->contato = $contato;
        $this->email = $email;
        $this->pessoaContato = $pessoaContato;
    }

    /**
     * @return mixed
     */
    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    /**
     * @param mixed $idFornecedor
     */
    public function setIdFornecedor($idFornecedor): void
    {
        $this->idFornecedor = $idFornecedor;
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
    public function getPessoaContato()
    {
        return $this->pessoaContato;
    }

    /**
     * @param mixed $pessoaContato
     */
    public function setPessoaContato($pessoaContato): void
    {
        $this->pessoaContato = $pessoaContato;
    }



    public function obterFornecedorPorID(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.fornecedor WHERE idFornecedor = :idFornecedor");
        $stmt->bindValue(":idFornecedor",$this->getIdFornecedor(),\PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!empty($dados))
        {
            $this->setDescricao($dados['descricao']);
            $this->setContato($dados['contato']);
            $this->setEmail($dados['email']);
            $this->setPessoaContato($dados['pessoaContato']);
        }
    }

    public function obterTodosFornecedores(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.fornecedor");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function atualizarFornecedor(?\PDO $conn)
    {
        $stmt = $conn->prepare("UPDATE feminina.fornecedor SET descricao = :descricao,contato = :contato,
                                        email = :email, pessoaContato = :pessoaContato WHERE idFornecedor = :idFornecedor");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":pessoaContato",$this->getPessoaContato(),\PDO::PARAM_STR);
        $stmt->bindValue(":idFornecedor",$this->getIdFornecedor(),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterFornecedorCadastrado(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.fornecedor WHERE descricao = :descricao");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function obterFornecedorCadastradoAtualizar(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.fornecedor WHERE descricao = :descricao AND idFornecedor <> :idFornecedor");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":idFornecedor",$this->getIdFornecedor(),\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function gravar(?\PDO $conn)
    {
        $stmt = $conn->prepare("INSERT INTO feminina.fornecedor (descricao,contato,email,pessoaContato)
                                        VALUES (:descricao,:contato,:email,:pessoaContato)");
        $stmt->bindValue(":descricao",$this->getDescricao(),\PDO::PARAM_STR);
        $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
        $stmt->bindValue(":pessoaContato",$this->getPessoaContato(),\PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function excluir(?\PDO $conn)
    {
        $stmt = $conn->prepare("DELETE FROM feminina.fornecedor WHERE idFornecedor = :idFornecedor");
        $stmt->bindValue(":idFornecedor",$this->getIdFornecedor(),\PDO::PARAM_INT);
        return $stmt->execute();
    }
}