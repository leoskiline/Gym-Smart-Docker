<?php

namespace App\Utils;

use App\Conexao\PDOConnection;
use Config\Connection;
use Slim\Views\PhpRenderer;
use PDO;

class AbstractSlimController
{
     protected PhpRenderer $view;
     protected PDO $conn;

     public function __construct()
     {
         $this->view = new PhpRenderer(__DIR__ . "/../");
         $this->conn = (new Connection())->getConnection();
     }
}