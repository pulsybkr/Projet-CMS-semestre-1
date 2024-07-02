<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\SqlPdo;
use App\Core\View;
class Main
{
    public function home()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/home", "Back");
        $sql = new \App\Core\SQL();
        $validate = new Validate();
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        
        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }

        $email = $sql->getUserIdFromCookie();
        if($email){
            if($validate->isFirstLog($email) && $view->isAdmin($pdo)){
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

    public function front()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/home");
        $sql = new \App\Core\SQL();
        $validate = new Validate();
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);

        echo $after_front;

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