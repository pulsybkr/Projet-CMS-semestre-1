<?php
namespace App\Controller;
use App\Core\View;
use App\Core\Security as Auth;

class Main
{
    public function home()
    {
        $security = new Auth();
        if($security->isFirstLog()){
            echo "azy louis";
        }else{
             //Appeler un template Front et la vue Main/Home
            $view = new View("Main/home");
            //$view->setView("Main/Home");
            $view->setTemplate("Back");
            $view->render();
        }
       
    }
    public function logout()
    {
        //Déconnexion
        //Redirection
    }


}