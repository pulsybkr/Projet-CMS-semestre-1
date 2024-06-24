<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\View;
class Main
{
    public function home()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/home", "Back");
        $sql = new \App\Core\SQL();
        $validate = new Validate();

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }

        $email = $sql->getUserIdFromCookie();
        if($email){
            if($validate->isFirstLog($email)){
                header("Location: /create-club"); 
                exit();
            }else{
                header("Location: /dashboard"); 
                exit();
            }
        }

        echo "on est connecté";
        //$view->setView("Main/Home");
        //$view->setTemplate("Front");
        $view->render();
    }
    public function logout()
    {
        //Déconnexion
        //Redirection
    }


}