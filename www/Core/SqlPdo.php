<?php

namespace App\Core;

use PDO;

class SqlPdo{
    private $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new PDO("pgsql:host=postgres;dbname=esgi;port=5432", "esgi", "esgipwd");

        } catch (\PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }

        
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function getTable()
    {
        $classChild = get_called_class();
        return $this->table = "esgi_" . strtolower(str_replace("App\\Models\\", "", $classChild));
    }
}