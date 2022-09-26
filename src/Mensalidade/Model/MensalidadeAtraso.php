<?php

namespace App\Mensalidade\Model;

use App\Aluno\Model\Aluno;

class MensalidadeAtraso
{
    private $idMensalidadeAtraso;
    private $aluno;
    private $mensalidade;

    /**
     * @param $idMensalidadeAtraso
     * @param $aluno
     * @param $mensalidade
     */
    public function __construct($idMensalidadeAtraso = null, $aluno = null, $mensalidade = null)
    {
        $this->idMensalidadeAtraso = $idMensalidadeAtraso;
        $this->aluno = $aluno;
        $this->mensalidade = $mensalidade;
    }

    /**
     * @return mixed
     */
    public function getIdMensalidadeAtraso()
    {
        return $this->idMensalidadeAtraso;
    }

    /**
     * @param mixed $idMensalidadeAtraso
     */
    public function setIdMensalidadeAtraso($idMensalidadeAtraso): void
    {
        $this->idMensalidadeAtraso = $idMensalidadeAtraso;
    }

    /**
     * @return mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param mixed $aluno
     */
    public function setAluno($aluno): void
    {
        $this->aluno = $aluno;
    }

    /**
     * @return mixed
     */
    public function getMensalidade()
    {
        return $this->mensalidade;
    }

    /**
     * @param mixed $mensalidade
     */
    public function setMensalidade($mensalidade): void
    {
        $this->mensalidade = $mensalidade;
    }

    public function obterMensalidadesEmAtrasoPorMensalidade(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("SELECT idMensalidadeAtraso,idAluno, idMensalidade FROM feminina.mensalidadeatraso WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":idMensalidade",$this->getMensalidade()->getIdMensalidade(),\PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(!empty($dados))
            {
                $this->setIdMensalidadeAtraso($dados['idMensalidadeAtraso']);
                $aluno = new Aluno($dados['idAluno'],null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
                $aluno->obterAlunoPorId($conn);
                $this->setAluno($aluno);
                $mensalidade = new Mensalidade($dados['idMensalidade'],null,null,null,null,null,null);
                $mensalidade->obterMensalidadePorId($conn);
                $this->setMensalidade($mensalidade);
            }else{
                $this->setIdMensalidadeAtraso(null);
            }
        }catch (\PDOException $e)
        {

        }
    }

    public function apagarMensalidadeAtraso(?\PDO $conn)
    {
        try{
            $stmt = $conn->prepare("DELETE FROM feminina.mensalidadeatraso WHERE idMensalidade = :idMensalidade");
            $stmt->bindValue(":idMensalidade",$this->getMensalidade(),\PDO::PARAM_INT);
            return $stmt->execute();
        }catch (\PDOException $e)
        {

        }
    }
}