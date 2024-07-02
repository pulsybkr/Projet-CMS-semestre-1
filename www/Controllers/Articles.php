<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\Form;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\Article;
use App\Models\Club;
use App\Models\Page;
use App\Models\User;
class Articles
{
    private $pdo;
    // if($userModel->deleteUser($this->pdo, $id)){
    //     echo "<p class='notification  notification--success'>Utilisateur supprimer avec success</p>";
    // } else{
    //     echo "<p class='notification  notification--danger'>Erreur je ne sais de quoi</p>";
    // } 


    public function create_article()
    {
        $form = new Form("Article");
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();

        if( $form->isSubmitted() && $form->isValid() )
        {
            $article = new Article();
            $article->setTitle($_POST["title"]);
            $article->setAuthor($_POST["author"]);
            $article->setContent($_POST["content"]);
            $article->create($this->pdo);
        }

        $view = new View("Security/create_article", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }
        $view->assign("form", $form->build());
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function update_article()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        $pagesModel = new Page();

        if (isset($_GET['id'])) {
            $articleId = intval($_GET['id']);
            $article = new Article();
            $articleData = $article->getArticleById($this->pdo, $articleId);
        }

        $view = new View("Security/update_article", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $content = $_POST['content'] ?? '';
        
            // Valider les données
            if (strlen($title) >= 5 && strlen($title) <= 255 &&
                strlen($author) >= 2 && strlen($author) <= 100 &&
                strlen($content) >= 20 && strlen($content) <= 5000) {
                $article->setTitle($title);
                $article->setAuthor($author);
                $article->setContent($content);                
                // Mettre à jour l'article dans la base de données
                $updated = $article->updateArticle($this->pdo, $articleId);
                
                if ($updated) {
                    echo "<p class='notification notification--success'>L'article a été mis à jour avec succès.</p>";
                    header("Location: /dashboard/article");
                } else {
                    echo "<p class='notification notification--danger'>Une erreur s'est produite lors de la mise à jour de l'article.</p>";
                }
            } else {
                echo "<p class='notification notification--danger'>Veuillez vérifier les champs du formulaire.</p>";
            }
        }

        $view->assign("articleData", $articleData);
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function delete_article()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        $pagesModel = new Page();

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = (int)$_GET['id']; 
            $page = $pagesModel->deletePageById($this->pdo, $id);
        } else {
            // Gérer le cas où 'id' n'est pas présent ou n'est pas valide
            header("Location: /error");
            exit();
        }

        $view = new View("Main/delete-page", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }

        if(!$page){
            die("page non trouver veuiller reessayer");
        }else{
            echo "<p class='notification  notification--success'>Page supprimer avec success</p>";
            header("Location: /dashboard/manages-pages");
        }


        $view->assign("page", $page);
        $view->render();
    }

    public function article()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/article", "Back");

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $articleModel = new Article();
        $articles = $articleModel->getAllArticles($this->pdo);


        // Passer les utilisateurs à la vue
        $view->assign("articles", $articles);
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