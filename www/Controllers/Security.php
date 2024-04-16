<?php
namespace App\Controller;
use App\Core\Security as Auth;
use App\Core\View;

class Security{


    public function login(): void
    {
        //Je vérifie que l'utilisateur n'est pas connecté sinon j'affiche un message
        $security = new Auth();
        if($security->isLogged()){
            echo "Vous êtes déjà connecté";
        }else{
            $view = new View("Main/login");
            $view->render();
    
        }
    }

    public function register(): void
    {
        echo "Inscription";
    }

    public function dashboard(): void
    {
        echo "Dashboard";
    }

    public function logout(): void
    {
        echo "Se déconnecter";
    }
}



















