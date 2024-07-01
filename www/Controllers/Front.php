<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\Page;
class Front
{
    public function home()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Front/home");
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $pages = new Page();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);

        if($pages->getPageContentByType($pdo, $after_front)){
            $page = $pages->getPageContentByType($pdo, $after_front);
            $view->assign("content", $page);
        }else{
            echo "page not found";
        }

        // echo $after_front;
        // echo "on est connecté";
        $view->render();
    }

}