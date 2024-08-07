<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\Form;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\User;

class Security{
    public function login(): void
    {
  
        $form = new Form("Login");
        $user = new User();
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();

        if ($user->adminExists($pdo)) {
            echo "<p class='notification notification--danger'>NB: Vous ne pouvez pas créer un compte, demandez à un admin de vous inviter !</p>";
            // Redirection or rendering a different view might be more appropriate here
            // header("Location: /login");
            // exit;
        }
        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setEmail($_POST["email"]);
            $user->connect($_POST["password"]);
        }

        $view = new View("Security/login");
        $view->assign("form", $form->build());
        $view->render();
    }
    public function register(): void
    {
        $form = new Form("Register");
        $view = new View("Security/register");

        $user = new User();
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();

        if ($user->adminExists($pdo)) {
            echo "<p class='notification notification--danger'>Vous ne pouvez pas créer un compte, demandez à un admin de vous inviter !</p>";
            // Redirection or rendering a different view might be more appropriate here
            header("Location: /login");
            // exit;
        } else {
            $view->assign("form", $form->build());

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setFirstname($_POST["firstname"]);
                $user->setLastname($_POST["lastname"]);
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);
                $user->save();
            }

            $view->render();
        }
    }
    public function logout(): void
    {
        echo "Se déconnecter";
    }
    
    public function reset_password(): void
    {
        // Récupérer la chaîne de requête de l'URL
        $queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
    
        // Parsez la chaîne de requête en un tableau associatif
        parse_str($queryString, $params);
    
        $token = $params['token'] ?? null;
    
        // Vérifier si le token et l'email sont vides
        if($token){
            $valide = new Validate();
            if(!$valide->isTokenValide($token) ){
                die("Le token c'est pas fonctionnelle ");
            }

            // echo $valide->isTokenValide($token);
            $form = new Form("Update_pwd");

            if( $form->isSubmitted() && $form->isValid() )
            {
                $user = new User();
                $user->setPassword($_POST["password"]);
                $user->setToken_reset_pwd($token);
                $user->update_password($_POST["password"]);
            }

            $view = new View("Security/update_pwd");
            $view->assign("form", $form->build());
            $view->render();
        } else {
            // echo "Mot de passe oublié";
            $form = new Form("Reset_pwd");

            if( $form->isSubmitted() && $form->isValid() )
            {
                $user = new User();
                $user->setEmail($_POST["email"]);
                $user->reset_password($_POST["email"]);
            }

            $view = new View("Security/reset_password");
            $view->assign("form", $form->build());
            $view->render();
        }
    }
    public function validate(): void
    {
        // Récupérer la chaîne de requête de l'URL
        $queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
    
        // Parsez la chaîne de requête en un tableau associatif
        parse_str($queryString, $params);
    
        $token = $params['token'] ?? null;
        $email = $params['email'] ?? null;
    
        // Vérifier si le token et l'email sont vides
        if(empty($token) || empty($email)){
            die("Erreur lors de la récupération des données. Veuillez réessayer avec le lien que vous avez reçu par e-mail, je suis désolé .");
        }
        
        $valide = new Validate();

        if($valide->isAccountActive($email)){
            die("Le compte est deja valider. connecte toi .");
        }

        if($valide->validateUser($email, $token)){
            echo "Votre compte a été validé avec succès .<br>";
        } else {
            echo "Aucun utilisateur trouvé avec ce token et cet email .<br>";
        }
    }
}



















