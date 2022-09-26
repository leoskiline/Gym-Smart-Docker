<?php

namespace App\Usuario\Model;

use Config\Connection;

class Permissoes
{
    public static function getPermissions()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("SELECT url FROM feminina.submenu WHERE permissoes like :permissoes");
        $stmt->bindValue(":permissoes", "%".$_SESSION['usuario']->getNivel()."%",\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}