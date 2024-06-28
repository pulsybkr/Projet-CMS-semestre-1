<?php
namespace App\Controller;
use App\Compenent\Validate;
use App\Core\Form;
use App\Core\SqlPdo;
use App\Core\View;
use App\Models\Club;
use App\Models\Page;
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
        $club = new Validate();
        $datas = $club->getClubById(1);
        
        // Passer les utilisateurs à la vue
        $view->assign("club", $datas);
        //$view->setView("Main/Home");
        //$view->setTemplate("Front");
        $view->render();
    }

    public function home()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/home", "Back");

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $club = new Validate();
        $datas = $club->getClubById(1);
        
        // Passer les utilisateurs à la vue
        $view->assign("club", $datas);
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

    public function create_club()
    {
        $form = new Form("ClubRegister");

        if( $form->isSubmitted() && $form->isValid() )
        {
            $club = new Club();
            $club->setName($_POST["club_name"]);
            $club->setCreationDate(date("creation_date")); 
            $club->setAddress($_POST["address"]);
            $club->setPhone($_POST["phone"]);
            $club->setEmail($_POST["email"]);
            $club->setDescription($_POST["description"]);
            // $user->setPassword($_POST["password"]);
            // echo "ça passe jusqu'ici";

            $club->add();
        }

        $view = new View("Security/create_projet", "Back");
        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $view->assign("form", $form->build());
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function create_page()
    {
        $form = new Form("PageRegister");
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();

        if ($form->isSubmitted() && $form->isValid()) {
            $page = new Page();
            $page->settitle($_POST["page_name"]);
            
            // Utilisation correcte de $_POST pour accéder à la valeur de "page_type"
            $page->settype($_POST["page_type"]); 
            if ($page->istypeExists($this->pdo, $_POST["page_type"])) {
                echo "Le type de page '".$_POST["page_type"]."' existe déjà.";
                // Tu peux choisir de rediriger l'utilisateur, afficher un message d'erreur, etc.
            } else {
                // Si le type de page n'existe pas encore, procède à l'insertion
                $page->newPage(); // Hypothétique méthode pour ajouter la page dans la base de données
                echo "Page créée avec succès.";
            }

        }

        $view = new View("Security/create_page", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }
        $view->assign("form", $form->build());
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function build_page()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        $pages = new Page();

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = (int)$_GET['id']; 
            $page = $pages->getPageById($this->pdo, $id);
        } else {
            // Gérer le cas où 'id' n'est pas présent ou n'est pas valide
            header("Location: /error");
            exit();
        }

        $view = new View("Main/builder", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }

        if(!$page){
            die("page non trouver veuiller reessayer");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            $pages->updatePageContent($this->pdo, $page['id'],  $content);
            // echo $content;
        }

        $view->assign("page", $page);
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function website_manager()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();

        $view = new View("Main/website_manager", "Back");
        if (!$view->isLog()) {
            header("Location: /login");
            exit();
        }
        $view->render();
        //Déconnexion
        //Redirection
    }

    public function allpages()
    {
        $sqlPdo = new SqlPdo();
        $this->pdo = $sqlPdo->getPdo();
        //Appeler un template Front et la vue Main/Home
        $view = new View("Main/manage_pages", "Back");

        if(!$view->isLog()){
            header("Location: /login");
            exit();
        }
        $pagesModel = new Page();
        $pages = $pagesModel->getAllPages($this->pdo);


        // Passer les utilisateurs à la vue
        $view->assign("pages", $pages);
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