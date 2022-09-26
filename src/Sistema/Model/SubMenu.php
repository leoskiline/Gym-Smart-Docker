<?php

namespace App\Sistema\Model;

class SubMenu
{
    private $idSubMenu;
    private $menu;
    private $url;
    private $classFontAwesome;
    private $titulo;
    private $permissoes;

    /**
     * @param $idSubMenu
     * @param $menu
     * @param $url
     * @param $classFontAwesome
     * @param $titulo
     * @param $permissoes
     */
    public function __construct($idSubMenu, $menu, $url, $classFontAwesome, $titulo, $permissoes)
    {
        $this->idSubMenu = $idSubMenu;
        $this->menu = $menu;
        $this->url = $url;
        $this->classFontAwesome = $classFontAwesome;
        $this->titulo = $titulo;
        $this->permissoes = $permissoes;
    }

    /**
     * @return mixed
     */
    public function getIdSubMenu()
    {
        return $this->idSubMenu;
    }

    /**
     * @param mixed $idSubMenu
     */
    public function setIdSubMenu($idSubMenu): void
    {
        $this->idSubMenu = $idSubMenu;
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu): void
    {
        $this->menu = $menu;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
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

    /**
     * @return mixed
     */
    public function getPermissoes()
    {
        return $this->permissoes;
    }

    /**
     * @param mixed $permissoes
     */
    public function setPermissoes($permissoes): void
    {
        $this->permissoes = $permissoes;
    }

    public function getSubMenu(?\PDO $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM feminina.submenu WHERE permissoes like :permissao and idMenu = :idMenu");
        $stmt->bindValue(":permissao","%".$_SESSION['usuario']->getNivel()."%",\PDO::PARAM_STR);
        $stmt->bindValue(":idMenu",$this->menu['idMenu'],\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}