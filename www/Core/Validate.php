<?php

namespace App\Compenent;
use App\Core\SqlPdo;
use App\Models\Club;
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

    public function isFirstLog(string $email): bool
    {
        $sql = "SELECT first_login FROM " . "esgi_user" . " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['first_login'] == 0) {
            return true; // Première connexion
        }
        return false; // Pas la première connexion
    }

    public function updateFirstLog(string $email): bool
    {
        $sql = "SELECT first_login FROM esgi_user WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['first_login'] == 0) {
            // Première connexion, mise à jour à 2
            $updateSql = "UPDATE esgi_user SET first_login = 2 WHERE email = :email";
            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute(['email' => $email]);

            return true;
        }

        return false; // Pas la première connexion ou l'utilisateur n'existe pas
    }

    public function getClubById(int $clubId): ?Club
    {
        $sql = "SELECT * FROM esgi_club WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $clubId]);
        $clubData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$clubData) {
            return null; 
        }

        $club = new Club();
        $club->setId($clubData['id']);
        $club->setName($clubData['name']);
        $club->setCreationDate($clubData['creation_date']);
        $club->setAddress($clubData['address']);
        $club->setPhone($clubData['phone']);
        $club->setEmail($clubData['email']);
        $club->setWebsite($clubData['website']);
        $club->setLogo($clubData['logo']);
        $club->setDescription($clubData['description']);

        return $club;
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
