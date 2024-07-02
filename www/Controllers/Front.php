<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\Comment;
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

    public function actu()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Front/actu");
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $pages = new Page();
        $commentModel = new Comment();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);
        $page = $pages->getPageContentByType($pdo, $after_front);

        if(!$page){
            echo "page not found";
        }else{
            $view->assign("content", $page);
            $view->assign("content", $page);

        }

        // $commentaire = $commentModel->getCommentsByArticleId($pdo);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $articleId = $_POST['article_id'];
            $comment = $_POST['comment'];
        
            // Valider et nettoyer les données
            $articleId = filter_var($articleId, FILTER_SANITIZE_NUMBER_INT);
            $comment = filter_var($comment, FILTER_SANITIZE_STRING);

            $commentModel->setArticleId($articleId);
            $commentModel->setContent($comment);
            $commentModel->setUserId(1);

            if($commentModel->create($pdo)){
                echo "<p class='notification notification--success'>Commentaire ajouter</>";
            }else{
                echo "<p class='notification notification--danger'>Erreur lors de l'ajout du commentaire</>";

            }
        }
        // echo $after_front;
        // echo "on est connecté";
        $view->render();
    }

    public function about()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Front/about");
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $pages = new Page();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);
        $page = $pages->getPageContentByType($pdo, $after_front);

        if($page){
            $view->assign("content", $page);
        }else{
            echo "page not found";
        }

        // echo $after_front;
        // echo "on est connecté";
        $view->render();
    }

    public function contact()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Front/contact");
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $pages = new Page();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);
        $page = $pages->getPageContentByType($pdo, $after_front);

        if($page){
            $view->assign("content", $page);
        }else{
            echo "page not found";
        }

        // echo $after_front;
        // echo "on est connecté";
        $view->render();
    }

    public function forum()
    {
        //Appeler un template Front et la vue Main/Home
        $view = new View("Front/forum");
        $sqlPdo = new SqlPdo();
        $pdo = $sqlPdo->getPdo();
        $pages = new Page();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Analyse l'URL et récupère le chemin
        $parsed_url = parse_url($url);
        $path = $parsed_url['path'];

        // Supprime la partie "/front/" du chemin
        $after_front = str_replace('/front/', '', $path);
        $page = $pages->getPageContentByType($pdo, $after_front);

        if($page){
            $view->assign("content", $page);
        }else{
            echo "page not found";
        }

        // echo $after_front;
        // echo "on est connecté";
        $view->render();
    }

}