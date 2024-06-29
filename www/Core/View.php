<?php
namespace App\Core;
use Exception;
use Firebase\JWT\JWT; 
use Firebase\JWT\Key;
use App\Models\User;
class View
{
    private $view;
    private $template;
    private $data = [];

    public function __construct(String $view, String $template="Front")
    {
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setView(String $view): void
    {
        $view = ucfirst(strtolower(trim($view)));
        if(!file_exists("../Views/".$view.".php")){
            die("La  vue ../Views/".$view.".php n'existe pas");
        }
        $this->view = $view;
    }
    

    public function isLog()
    {
        $cookieName = "esgi_cc";
        if (isset($_COOKIE[$cookieName])) {
            $token = $_COOKIE[$cookieName];
            
            try {
                // Vérifier si le token est valide en le décodant
                $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
                
                // Vérifier si le token a expiré
                if ($decoded->exp < time()) {
                    // Le token a expiré
                    return false;
                }
                
                // Le token est valide
                return true;
            } catch (Exception $e) {
                // Une exception s'est produite lors du décodage du token
                return false;
            }
        }
        return false;
    }

    public function isAdmin($pdo)
    {
        $cookieName = "esgi_cc";
        if (isset($_COOKIE[$cookieName])) {
            $token = $_COOKIE[$cookieName];
            
            try {
                // Vérifier si le token est valide en le décodant
                $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
                
                // Vérifier si le token a expiré
                if ($decoded->exp < time()) {
                    // Le token a expiré
                    return false;
                }
                
                // Le token est valide
                $userId = $decoded->user_id;
                $user = new User();

                if($userId && $user->isAdminById($pdo, $userId)) {
                    return true;
                }else
                {
                    return false;
                }
            } catch (Exception $e) {
                // Une exception s'est produite lors du décodage du token
                return false;
            }
        }
        return false;
    }

    public function logout()
    {
        // Détruire le cookie en le rendant expiré
        $cookieName = "esgi_cc";
        setcookie($cookieName, "", time() - 3600, "/"); 
        
        // Effacer également le cookie en mémoire
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
        }

        header("Location: /login"); 
        exit;
    }

    public function setTemplate(String $template): void
    {
        $template = strtolower(trim($template));
        if(!file_exists("../Views/Templates/".$template.".php")){
            die("Le template ../Views/Templates/".$template.".php n'existe pas");
        }
        $this->template = $template;
    }


    public function assign($key, $value): void{
        $this->data[$key] = $value;
    }

    public function render(): void
    {
        extract($this->data);
        //echo "Le template c'est ".$this->template." et la vue ".$this->view;
        include "../Views/Templates/".$this->template.".php";
    }

}





















