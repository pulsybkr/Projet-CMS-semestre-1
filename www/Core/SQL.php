<?php

namespace App\Core;

use PDO;

class SQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=mariadb;dbname=esgi;port=3306", "esgi", "esgipwd");
        } catch (\PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }

        $classChild = get_called_class();
        $this->table = "esgi_" . strtolower(str_replace("App\\Models\\", "", $classChild));
    }

    public function save()
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        if (empty($this->getId())) {
            $sql = "INSERT INTO " . $this->table . " (" . implode(', ', array_keys($columns)) . ")  
            VALUES (:" . implode(',:', array_keys($columns)) . ")";
        } else {
            foreach ($columns as $column => $value) {
                $sqlUpdate[] = $column . "=:" . $column;
            }

            $sql = "UPDATE " . $this->table . " SET " . implode(',', $sqlUpdate) . " WHERE id=" . $this->getId();
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($columns);
    }

    public function connect($password)
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        if ($this->isEmailAvailable($columns["email"])) {
            die("Cette adresse n'est pas enregistrée. Veuillez créer un compte.");
        }

        if(!$this->checkPassword($columns["email"], $password)){
            die("Mot de passe incorrect");
        }

        echo "ça arrive";
        // Code de vérification du mot de passe ici
    }

    public function isEmailAvailable(string $email): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['count'] == 0); // True si l'e-mail est disponible, sinon False
    }

    public function checkPassword(string $email, string $password): bool
    {
        $sql = "SELECT password FROM ".$this->table." WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            return true; // Mot de passe correct
        }
        return false; // Mot de passe incorrect ou e-mail introuvable
    }
}
