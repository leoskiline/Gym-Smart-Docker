<?php

namespace App\Sistema\Model;

class Menu
{
    private $idMenu;
    private $classFontAwesome;
    private $titulo;

    /**
     * @param $idMenu
     * @param $classFontAwesome
     * @param $titulo
     */
    public function __construct($idMenu, $classFontAwesome, $titulo)
    {
        $this->idMenu = $idMenu;
        $this->classFontAwesome = $classFontAwesome;
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * @param mixed $idMenu
     */
    public function setIdMenu($idMenu): void
    {
        $this->idMenu = $idMenu;
    }

    /**
     * @return mixed
     */
    public function getClassFontAwesome()
    {
        return $this->classFontAwesome;
    }

    /**
     * @param mixed $classFontAwesome
     */
    public function setClassFontAwesome($classFontAwesome): void
    {
        $this->classFontAwesome = $classFontAwesome;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }


    public function getMenu(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.menu");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}