<?php

namespace App\Sistema\Model;

use Config\Connection;
use PDO;

class Informacoes
{
    private $idInformacoesSistema;
    private $tituloLogin;
    private $tituloNavbar;
    private $nomeSistema;
    private $cnpj;
    private $contato;
    private $email;
    private $logo;
    private $rua;
    private $nrcasa;
    private $bairro;
    private $cidade;
    private $uf;
    private $pais;
    private $cep;

    /**
     * @param $idInformacoesSistema
     * @param $tituloLogin
     * @param $tituloNavbar
     * @param $nomeSistema
     * @param $cnpj
     * @param $contato
     * @param $email
     * @param $logo
     * @param $rua
     * @param $nrcasa
     * @param $bairro
     * @param $cidade
     * @param $uf
     * @param $pais
     * @param $cep
     */
    public function __construct($idInformacoesSistema, $tituloLogin, $tituloNavbar, $nomeSistema, $cnpj, $contato, $email, $logo, $rua, $nrcasa, $bairro, $cidade, $uf, $pais, $cep)
    {
        $this->idInformacoesSistema = $idInformacoesSistema;
        $this->tituloLogin = $tituloLogin;
        $this->tituloNavbar = $tituloNavbar;
        $this->nomeSistema = $nomeSistema;
        $this->cnpj = $cnpj;
        $this->contato = $contato;
        $this->email = $email;
        $this->logo = $logo;
        $this->rua = $rua;
        $this->nrcasa = $nrcasa;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->pais = $pais;
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getIdInformacoesSistema()
    {
        return $this->idInformacoesSistema;
    }

    /**
     * @param mixed $idInformacoesSistema
     */
    public function setIdInformacoesSistema($idInformacoesSistema): void
    {
        $this->idInformacoesSistema = $idInformacoesSistema;
    }

    /**
     * @return mixed
     */
    public function getTituloLogin()
    {
        return $this->tituloLogin;
    }

    /**
     * @param mixed $tituloLogin
     */
    public function setTituloLogin($tituloLogin): void
    {
        $this->tituloLogin = $tituloLogin;
    }

    /**
     * @return mixed
     */
    public function getTituloNavbar()
    {
        return $this->tituloNavbar;
    }

    /**
     * @param mixed $tituloNavbar
     */
    public function setTituloNavbar($tituloNavbar): void
    {
        $this->tituloNavbar = $tituloNavbar;
    }

    /**
     * @return mixed
     */
    public function getNomeSistema()
    {
        return $this->nomeSistema;
    }

    /**
     * @param mixed $nomeSistema
     */
    public function setNomeSistema($nomeSistema): void
    {
        $this->nomeSistema = $nomeSistema;
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj): void
    {
        $this->cnpj = $cnpj;
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
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
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

    public function obterInformacoesSistema(PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idInformacoes_Sistema,tituloLogin,tituloNavbar,nomeSistema,cnpj,contato,email,logo,rua,nrcasa,bairro,cidade,uf,pais,cep FROM feminina.informacoes_sistema");
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function gravarInformacoesSistema(PDO $conn)
    {
        try{
            $retorno = false;
            $stmt = $conn->prepare("INSERT INTO feminina.informacoes_sistema (tituloLogin,tituloNavbar,nomeSistema,cnpj,contato,email,logo,rua,nrcasa,bairro,cidade,uf,pais,cep) VALUES (:tituloLogin,:tituloNavbar,:nomeSistema,:cnpj,:contato,:email,:logo,:rua,:nrcasa,:bairro,:cidade,:uf,:pais,:cep)");
            $stmt->bindValue(":tituloLogin",$this->getTituloLogin(),\PDO::PARAM_STR);
            $stmt->bindValue(":tituloNavbar",$this->getTituloNavbar(),\PDO::PARAM_STR);
            $stmt->bindValue(":nomeSistema",$this->getNomeSistema(),\PDO::PARAM_STR);
            $stmt->bindValue(":cnpj",$this->getCnpj(),\PDO::PARAM_STR);
            $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
            $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
            $stmt->bindValue(":logo",$this->getLogo(),\PDO::PARAM_STR);
            $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
            $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_STR);
            $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
            $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
            $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
            $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
            $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
            if($stmt->execute()){
                $this->setIdInformacoesSistema($conn->lastInsertId());
                $retorno = true;
            }
            return $retorno;
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function getInformacoesById($idInformacoes_Sistema, \PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT * FROM feminina.informacoes_sistema WHERE idInformacoes_Sistema = :info");
            $stmt->bindValue(":info",$idInformacoes_Sistema,\PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }

    public function atualizarInformacoesById(\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("UPDATE feminina.informacoes_sistema SET tituloLogin = :tituloLogin, tituloNavbar = :tituloNavbar,
                                       nomeSistema = :nomeSistema,cnpj = :cnpj,contato = :contato,email = :email,logo = :logo,
                                    rua = :rua,nrcasa = :nrcasa,bairro = :bairro,cidade = :cidade,uf = :uf,pais = :pais,cep = :cep WHERE idInformacoes_Sistema = :idInfo");
            $stmt->bindValue(":idInfo",$this->getIdInformacoesSistema(),\PDO::PARAM_INT);
            $stmt->bindValue(":tituloLogin",$this->getTituloLogin(),\PDO::PARAM_STR);
            $stmt->bindValue(":tituloNavbar",$this->getTituloNavbar(),\PDO::PARAM_STR);
            $stmt->bindValue(":nomeSistema",$this->getNomeSistema(),\PDO::PARAM_STR);
            $stmt->bindValue(":cnpj",$this->getCnpj(),\PDO::PARAM_STR);
            $stmt->bindValue(":contato",$this->getContato(),\PDO::PARAM_STR);
            $stmt->bindValue(":email",$this->getEmail(),\PDO::PARAM_STR);
            $stmt->bindValue(":logo",$this->getLogo(),\PDO::PARAM_STR);
            $stmt->bindValue(":rua",$this->getRua(),\PDO::PARAM_STR);
            $stmt->bindValue(":nrcasa",$this->getNrcasa(),\PDO::PARAM_STR);
            $stmt->bindValue(":bairro",$this->getBairro(),\PDO::PARAM_STR);
            $stmt->bindValue(":cidade",$this->getCidade(),\PDO::PARAM_STR);
            $stmt->bindValue(":uf",$this->getUf(),\PDO::PARAM_STR);
            $stmt->bindValue(":pais",$this->getPais(),\PDO::PARAM_STR);
            $stmt->bindValue(":cep",$this->getCep(),\PDO::PARAM_STR);
            return $stmt->execute();
        }catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
    }
}