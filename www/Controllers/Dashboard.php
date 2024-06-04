<?php
namespace App\Controller;
use App\Core\Form;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\User;
class Dashboard
{
    private $pdo;
    public function user()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/dashboard", "Back");

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $userModel = new User();
        $users = $userModel->getAllUsers($this->pdo);

        // Passer les utilisateurs à la vue
        $view->assign("users", $users);
        echo "c'est ici pour update les users";
        //$view->setView("Main/Home");
        //$view->setTemplate("Front");
        $view->render();
    }

    public function invite()
    {
        echo "ici c'est pour inviter des utilisateurs au projet";
        $form = new Form("Register");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $user = new User();
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            // $user->setPassword($_POST["password"]);
            // $user->save();
        }

        $view = new View("Security/invite", "Back");
        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $view->assign("form", $form->build());
        $view->render();
        //Déconnexion
        //Redirection
    }
    public function logout()
    {
        //Déconnexion
        //Redirection
    }


}