<?php

namespace App\Sistema\Controller;

use App\Sistema\Model\Menu;
use App\Sistema\Model\SubMenu;
use Config\Connection;

class MenuController
{
    private static $conn;

    public static function getNomeUsuario()
    {
        $nome = "";
        if(!empty($_SESSION['usuario']->getAdministrador()))
        {
            $nome = $_SESSION['usuario']->getAdministrador()->getNome();
        }
        if(!empty($_SESSION['usuario']->getInstrutor()))
        {
            $nome = $_SESSION['usuario']->getInstrutor()->getNome();
        }
        if(!empty($_SESSION['usuario']->getProfessor()))
        {
            $nome = $_SESSION['usuario']->getProfessor()->getNome();
        }
        $nome .= " (".$_SESSION['usuario']->getNivel().")";
        return $nome;
    }

    public static function getMenu()
    {
        $conn = (new Connection())->getConnection();
        $menu = new Menu(null,null,null);
        $arrayMenu = $menu->getMenu($conn);
        $submenus = [];
        $menus = [];
        if(is_array($arrayMenu))
        {
            foreach ($arrayMenu as $arr)
            {
                $menu = ["idMenu" => $arr['idMenu'],"classFontAwesome" => $arr['classFontAwesome'], 'titulo' =>$arr['titulo'] , 'submenus' => []];
                $submenu = new SubMenu(null,$menu,null,null,null,null);
                $arraySubMenu = $submenu->getSubMenu($conn);
                foreach ($arraySubMenu as $key => $arrsub)
                {
                    $menu['submenus'][$key] = ["idSubMenu" => $arrsub['idSubmenu'],"url" => $arrsub['url'], "classFontAwesome" => $arrsub['classFontAwesome'], "titulo" => $arrsub['titulo']];
                }
                if(count($menu['submenus']))
                    $menus[] = $menu;
            }
            $html = "";
            foreach ($menus as $mn){
                $html .= '<li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="'.$mn['classFontAwesome'].'"></i>
                                    <p>
                                        '.$mn['titulo'].'
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>';
                foreach ($mn['submenus'] as $key2 => $sm){
                    if($key2 == 0)
                    {
                        $html .= '<ul class="nav nav-treeview">
                                            <li class="nav-item">
                                        <a href="'.$sm['url'].'" class="nav-link">
                                            <i class="'.$sm['classFontAwesome'].' nav-icon"></i>
                                            <p>'.$sm['titulo'].'</p>
                                        </a>
                                    </li>';
                    }else if($key2 == count($mn['submenus'])-1 ){
                        $html .= '<li class="nav-item">
                                <a href="'.$sm['url'].'" class="nav-link">
                                    <i class="'.$sm['classFontAwesome'].' nav-icon"></i>
                                    <p>'.$sm['titulo'].'</p>
                                </a>
                            </li></ul>';
                    }else{
                        $html .= '<li class="nav-item">
                                <a href="'.$sm['url'].'" class="nav-link">
                                    <i class="'.$sm['classFontAwesome'].' nav-icon"></i>
                                    <p>'.$sm['titulo'].'</p>
                                </a>
                            </li>';
                    }
                }
                $html .= "</li>";
            }
        }
        return $html;
    }
}