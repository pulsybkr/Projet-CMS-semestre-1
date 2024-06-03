<?php

namespace App\Core;
use Firebase\JWT\JWT; 
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';
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

        // token de validation
        $tokenValidation = bin2hex(random_bytes(32));
        $columns['token_validation'] = $tokenValidation;

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

        // Envoyer l'email de validation
        $toEmail = $columns['email'];
        $toName = $columns['firstname'];
        $validationLink = "http://localhost/validate?token=$tokenValidation&email=$toEmail";
        $this->sendValidationEmail($toEmail, $toName, $validationLink);
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

    public function reset_password($email)
    {
        // Requête SQL pour vérifier si un utilisateur avec cet email existe
        $sql = "SELECT * FROM esgi_user WHERE email = :email";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['email' => $email]);
        $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un utilisateur avec cet email a été trouvé
        if (!$user) {
            die("L'email n'est pas dans la base de données mon bebou. Je vois ce que tu essaies de faire mais ça ne va pas passer.");
        }

        $token = bin2hex(random_bytes(32));

        // Mettre à jour le token de réinitialisation de mot de passe pour l'utilisateur
        $updateSql = "UPDATE esgi_user SET token_reset_pwd = :token WHERE id = :id";
        $updateQueryPrepared = $this->pdo->prepare($updateSql);
        $updateQueryPrepared->execute(['token' => $token, 'id' => $user['id']]);

        $validationLink = "http://localhost/reset_password?token=$token";

        // Envoyer l'email de réinitialisation de mot de passe
        $this->sendResetEmail($email, $validationLink);
    }

    public function update_password($password)
    {   
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        // Requête SQL pour vérifier si un utilisateur avec ce token existe
        $sql = "SELECT * FROM esgi_user WHERE token_reset_pwd = :token";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute(['token' => $columns["token_reset_pwd"]]);
        $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un utilisateur avec ce token a été trouvé
        if (!$user) {
            die("Le token n'est pas fonctionnel, mon bebou d'amour.");
        }

        if($user && password_verify($password, $user['password'])){
            die("Le nouveau mot de passe doit être different de l'ancien mon bebou d'amour");
        }

        // echo "ça passe je ne fais pourquoi ";

        // Mettre à jour le mot de passe et réinitialiser le token de réinitialisation de mot de passe
        $updateSql = "UPDATE esgi_user SET password = :password, token_reset_pwd = NULL WHERE id = :id";
        $updateQueryPrepared = $this->pdo->prepare($updateSql);
        $updateResult = $updateQueryPrepared->execute(['password' => $columns['password'], 'id' => $user['id']]);

        if ($updateResult) {
            echo "Votre mot de passe a été mis à jour avec succès.";
        } else {
            echo "Une erreur s'est produite lors de la mise à jour de votre mot de passe.";
        }
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
        $sql = "SELECT id, password FROM " . "esgi_user" . " WHERE email = :email";
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

    private function sendValidationEmail($toEmail, $toName, $validationLink) {
        $mail = new PHPMailer(true);
    
        try {
            // Configurations du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailgun.org'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'postmaster@sandboxe8ff871a99a149228de1e445a0ee40ac.mailgun.org'; 
            $mail->Password = '3b6afcffa8d9be8cf53e5baa76eecf58-8c90f339-425243c4'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 
    
            // Destinataire
            $mail->setFrom('nepasrepondre@esgi.com', 'ClubWebsiteCMS');
            $mail->addAddress($toEmail, $toName);
    
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Validation de votre compte';
            $mail->Body    = "Bonjour $toName,<br><br>Merci de vous être inscrit. Veuillez cliquer sur le lien suivant pour valider votre compte :<br><a href='$validationLink'>Lien de validation</a><br><br>Merci,<br>L'équipe";
            $mail->AltBody = "Bonjour $toName,\n\nMerci de vous être inscrit. Veuillez cliquer sur le lien suivant pour valider votre compte :\n$validationLink\n\nMerci,\nL'équipe";
    
            $mail->send();
            echo 'Le message a été envoyé avec succès';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
        }
    }

    private function sendResetEmail($toEmail, $validationLink) {
        $mail = new PHPMailer(true);
    
        try {
            // Configurations du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailgun.org'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'postmaster@sandboxe8ff871a99a149228de1e445a0ee40ac.mailgun.org'; 
            $mail->Password = '3b6afcffa8d9be8cf53e5baa76eecf58-8c90f339-425243c4'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 
    
            // Destinataire
            $mail->setFrom('nepasrepondre@esgi.com', 'ClubWebsiteCMS');
            $mail->addAddress($toEmail, " ");
    
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Mot de passe oublié';
            $mail->Body    = "Bonjour ,<br><br>Voici le lien pour modifié votre mot de passe mon bebou d'amour :<br><a href='$validationLink'>Lien de validation</a><br><br>Merci,<br>L'équipe";
            $mail->AltBody = "Bonjour ,\n\nVoici le lien pour modifié votre mot de passe mon bebou d'amour :\n$validationLink\n\nMerci,\nL'équipe";
    
            $mail->send();
            echo 'Le mail pour changer votre email à été envoyer.';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
        }
    }

}
