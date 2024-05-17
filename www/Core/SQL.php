<?php

namespace App\Core;
use Firebase\JWT\JWT; 

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

        if (!$this->isAccountActive($columns["email"])) {
            die("Ce compte n'est pas activé. Veuillez vérifier votre e-mail.");
        }

        $userId = $this->checkPassword($columns["email"], $password);

        if (!$userId) {
            die("Mot de passe incorrect");
        }

        $this->createUserCookie($userId, $columns["email"]);

        echo "Connexion réussie";
        
    }

    public function isEmailAvailable(string $email): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['count'] == 0); // True si l'e-mail est disponible, sinon False
    }

    public function isAccountActive(string $email): bool
    {
        $sql = "SELECT status FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['status'] > 0) {
            return true; // Le compte est activé
        }
        return false; // Le compte n'est pas activé ou l'e-mail n'existe pas
    }

    public function checkPassword(string $email, string $password)
    {
        $sql = "SELECT id, password FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            return $result['id']; // Retourne l'ID de l'utilisateur si le mot de passe est correct
        }
        return null; // Mot de passe incorrect ou e-mail introuvable
    }

    private function createUserCookie($userId, $email)
    {
         // La connexion est réussie, nous créons le cookie JWT
         $token = $this->createUserToken($userId, $email);
         setcookie('esgi_cc', $token, time() + (60 * 60 ), '/', '', true, true); 
    }

    public function createUserToken($userId, $email)
    {
        $payload = [
            'user_id' => $userId,
            'email' => $email,
            'exp' => time() + (60 * 60 * 24),
        ];

        $token = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');

        return $token;
    }

}
