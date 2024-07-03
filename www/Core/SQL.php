<?php

namespace App\Core;
use App\Compenent\Validate;
use Firebase\JWT\JWT; 
use Firebase\JWT\Key;
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
            $this->pdo = new PDO("pgsql:host=postgres;dbname=esgi;port=5432", "esgi", "esgipwd");

        } catch (\PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }

        $classChild = get_called_class();
        $this->table = "esgi_" . strtolower(str_replace("App\\Models\\", "", $classChild));
    }

    public function add()
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        // token de validation
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

        $sql = new SQL();
        $validate = new Validate();
        $email = $sql->getUserIdFromCookie();
        if (!$validate->updateFirstLog($email)){
            die("Error de la modification du status de l'user");
        }else{
            header("Location: /dashboard"); 
        }

    }

    public function newPage()
    {
        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        // token de validation
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
    public function save()
    {
    // Vérifier si l'email existe déjà
    $existingEmail = $this->findByEmail($this->email);
    
    if ($existingEmail) {
        // Gérer le cas où l'email existe déjà
        echo "<p class='notification  notification--danger'>Email already exists.</p>";
        return;
    }

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
        $domain = getenv('DOMAIN');
        $validationLink = "http://$domain/validate?token=$tokenValidation&email=$toEmail";
        $this->sendValidationEmail($toEmail, $toName, $validationLink);
    }

    private function findByEmail($email)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $query = $this->pdo->prepare($sql);
        $query->execute(['email' => $email]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function connect($password)
    {

        $columnsAll = get_object_vars($this);
        $columnsToDelete = get_class_vars(get_class());
        $columns = array_diff_key($columnsAll, $columnsToDelete);

        if ($this->isEmailAvailable($columns["email"])) {
            echo "<p class='notification  notification--danger'>Cette adresse n'est pas enregistrée. Veuillez créer un compte.</p>";
            return;
        }

        if (!$this->isAccountActive($columns["email"])) {
            echo "<p class='notification  notification--danger'>Ce compte n'est pas activé. Veuillez vérifier votre e-mail.";
            return;
        }

        $userId = $this->checkPassword($columns["email"], $password);

        if (!$userId) {
            echo "<p class='notification  notification--danger'>Mot de passe incorrect";
            return;
        }

        $this->createUserCookie($userId, $columns["email"]);

        echo "<p class='notification  notification--success'>Connexion réussie</p>";
        header("Location: /"); 
        
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
            echo "<p class='notification  notification--danger'>L'email n'est pas dans la base de données mon bebou. Je vois ce que tu essaies de faire mais ça ne va pas passer.";
            return;
        }

        $token = bin2hex(random_bytes(32));

        // Mettre à jour le token de réinitialisation de mot de passe pour l'utilisateur
        $updateSql = "UPDATE esgi_user SET token_reset_pwd = :token WHERE id = :id";
        $updateQueryPrepared = $this->pdo->prepare($updateSql);
        $updateQueryPrepared->execute(['token' => $token, 'id' => $user['id']]);
        $domain = getenv('DOMAIN');
        $validationLink = "http://$domain/reset_password?token=$token";

        // Envoyer l'email de réinitialisation de mot de passe
        $this->sendResetEmail($email, $validationLink);
        echo "<p class='notification  notification--success'>Email envoyé avec success</p>";
        header("Location: /");
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
            echo "<p class='notification  notification--danger'>Le token n'est pas fonctionnel, mon bebou d'amour.";
            return;
        }

        if($user && password_verify($password, $user['password'])){
            echo "<p class='notification  notification--danger'>Le nouveau mot de passe doit être different de l'ancien mon bebou d'amour";
            return;
        }

        // echo "ça passe je ne fais pourquoi ";

        // Mettre à jour le mot de passe et réinitialiser le token de réinitialisation de mot de passe
        $updateSql = "UPDATE esgi_user SET password = :password, token_reset_pwd = NULL WHERE id = :id";
        $updateQueryPrepared = $this->pdo->prepare($updateSql);
        $updateResult = $updateQueryPrepared->execute(['password' => $columns['password'], 'id' => $user['id']]);

        if ($updateResult) {
            echo "<p class='notification  notification--success'>Votre mot de passe a été mis à jour avec succès.</p>";
            header("Location: /login");

        } else {
            echo "<p class='notification  notification--success'>Une erreur s'est produite lors de la mise à jour de votre mot de passe.</p>";

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
         setcookie('esgi_cc', $token, time() + (60 * 60 * 60 ), '/', '', true, true); 
    }

    public function getUserIdFromCookie()
    {
        if (isset($_COOKIE['esgi_cc'])) {
            $token = $_COOKIE['esgi_cc'];

            try {
                $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
                return $decoded->email;
            } catch (Exception $e) {
                // Gérer l'erreur (par exemple, token expiré ou invalide)
                return null;
            }
        }
        return null;
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
            $mail->Host = 'mail.smtp2go.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'tikss-cg.com'; 
            $mail->Password = 'M4iUWZUe2A3DBO0X'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 2525; 
    
            // Destinataire
            $mail->setFrom('contact@tikss-cg.com', 'ClubWebsiteCMS');
            $mail->addAddress($toEmail, $toName);
    
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Validation de votre compte';
            $mail->Body    = "Bonjour $toName,<br><br>Merci de vous être inscrit. Veuillez cliquer sur le lien suivant pour valider votre compte :<br><a href='$validationLink'>Lien de validation</a><br><br>Merci,<br>L'équipe";
            $mail->AltBody = "Bonjour $toName,\n\nMerci de vous être inscrit. Veuillez cliquer sur le lien suivant pour valider votre compte :\n$validationLink\n\nMerci,\nL'équipe";
    
            $mail->send();
            echo "<p class='notification  notification--success'/>Le message a été envoyé avec succès</p>";
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
        }
    }

    private function sendResetEmail($toEmail, $validationLink) {
        $mail = new PHPMailer(true);
    
        try {
            // Configurations du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'mail.smtp2go.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'tikss-cg.com'; 
            $mail->Password = 'M4iUWZUe2A3DBO0X'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 2525; 
    
            // Destinataire
            $mail->setFrom('contact@tikss-cg.com', 'ClubWebsiteCMS');
            $mail->addAddress($toEmail, " ");
    
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Mot de passe oublié';
            $mail->Body    = "Bonjour ,<br><br>Voici le lien pour modifié votre mot de passe mon bebou d'amour :<br><a href='$validationLink'>Lien de validation</a><br><br>Merci,<br>L'équipe";
            $mail->AltBody = "Bonjour ,\n\nVoici le lien pour modifié votre mot de passe mon bebou d'amour :\n$validationLink\n\nMerci,\nL'équipe";
    
            $mail->send();
            echo "<p class='notification  notification--success'/>Le mail pour changer votre mot de passe à été envoyer.</p>";
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
        }
    }

}
