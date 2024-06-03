<?php

namespace App\Compenent;
use App\Core\SqlPdo;
use PDO;
class Validate
{
    private $pdo;
    private $table;
    public function __construct()
    {
        $sql = new SqlPdo();
        $this->pdo = $sql->getPdo();
    }

    public function validateUser($email, $token)
    {
        // Requête SQL pour vérifier si un utilisateur avec ce token et cet email existe
        $sql = "SELECT * FROM esgi_user WHERE token_validation = :token AND email = :email";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['token' => $token, 'email' => $email]);
        $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si un utilisateur avec ce token et cet email a été trouvé
        if(!$user){
            return false;
        }

        // Mettre à jour le statut de l'utilisateur à 1
        $updateSql = "UPDATE esgi_user SET status = 1, token_validation = NULL WHERE id = :id";
        $updateQueryPrepared = $this->pdo->prepare($updateSql);
        $updateQueryPrepared->execute(['id' => $user['id']]);

        return true;
    }

    public function isAccountActive(string $email): bool
    {
        $sql = "SELECT status FROM " . "esgi_user" . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['status'] > 0) {
            return true; // Le compte est activé
        }
        return false; // Le compte n'est pas activé ou l'e-mail n'existe pas
    }

    public function isTokenValide(string $token): bool
    {
        $sql = "SELECT status FROM " . "esgi_user" . " WHERE token_reset_pwd = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['status'] > 0) {
            return true; // le token existe et est valide
        }
        return false; // Le token n'est pas valide
    }

}
