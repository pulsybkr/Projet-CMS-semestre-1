<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\Form;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\Article;
use App\Models\Club;
use App\Models\Comment;
use App\Models\Page;
use App\Models\User;
class Comments
{
    private $pdo;
    // if($userModel->deleteUser($this->pdo, $id)){
    //     echo "<p class='notification  notification--success'>Utilisateur supprimer avec success</p>";
    // } else{
    //     echo "<p class='notification  notification--danger'>Erreur je ne sais de quoi</p>";
    // } 

    public function delete_comment()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        $pagesModel = new Comment();

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = (int)$_GET['id']; 
            $comments = $pagesModel->deleteComment($this->pdo, $id);
        } else {
            // Gérer le cas où 'id' n'est pas présent ou n'est pas valide
            header("Location: /error");
            exit();
        }

        $view = new View("Main/delete-comment", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }

        if(!$comments){
            die("Commentaire non trouver veuiller reessayer");
        }else{
            echo "<p class='notification  notification--success'>Commentaire supprimer avec success</p>";
        }

        $view->assign("comments", $comments);
        $view->render();
    }

    public function comments()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/comment", "Back");

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $commentModel = new Comment();
        $comments = $commentModel->getAllComments($this->pdo);

        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            echo "demande de quelque chose";
        }
        // Passer les utilisateurs à la vue
        $view->assign("comments", $comments);
        //$view->setView("Main/Home");
        //$view->setTemplate("Front");
        $view->render();
    }


}