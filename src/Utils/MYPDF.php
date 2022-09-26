<?php

namespace App\Utils;

use TCPDF;

class MYPDF extends TCPDF {

    private $emitidoPor;

    /**
     * @return mixed
     */
    public function getEmitidoPor()
    {
        return $this->emitidoPor;
    }

    /**
     * @param mixed $emitidoPor
     */
    public function setEmitidoPor($emitidoPor): void
    {
        $this->emitidoPor = $emitidoPor;
    }

    //Page header
    public function Header() {
        // Logo
        $image_file = __DIR__."/../..".$_SESSION['informacoesSistema']->getLogo();
        $explode = explode("/",$_SESSION['informacoesSistema']->getLogo());
        $explode2 = explode(".",$explode[count($explode) - 1]);
        $ext = strtoupper($explode2[count($explode2) -1]);
        $this->Image($image_file, 10, 10, 15, '', $ext, '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Title
        $titulo = $_SESSION['informacoesSistema']->getNomeSistema();
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, $titulo, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(0, 15, date("d/m/Y H:i:s"), 0, true, 'R', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $endereço = "Endereço: ".$_SESSION['informacoesSistema']->getRua()." ".$_SESSION['informacoesSistema']->getNrCasa()." Bairro: ".$_SESSION['informacoesSistema']->getBairro()." Cidade: ".$_SESSION['informacoesSistema']->getCidade()." / ".$_SESSION['informacoesSistema']->getUf()." - ".$_SESSION['informacoesSistema']->getPais();
        $this->Cell(0, 8, $endereço, 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $subtitulo = "Contato: ".$_SESSION['informacoesSistema']->getContato()." CNPJ: ".$_SESSION['informacoesSistema']->getCnpj()." Email: ".$_SESSION['informacoesSistema']->getEmail();
        $this->Cell(0, 15, $subtitulo, 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Emitido por '.$this->getEmitidoPor(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}