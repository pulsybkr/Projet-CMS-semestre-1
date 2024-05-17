<?php

namespace App;
// index.php

// Chargement des dépendances et configuration de l'application
spl_autoload_register("App\myAutoloader");

function myAutoloader($class){
    $classExploded = explode("\\", $class);
    $class = end($classExploded);
    if(file_exists("../Core/".$class.".php")){
        include "../Core/".$class.".php";
    }
    if(file_exists("../Models/".$class.".php")){
        include "../Models/".$class.".php";
    }
}

// Récupération de l'URI
$uri = $_SERVER["REQUEST_URI"];
if(strlen($uri) > 1)
    $uri = rtrim($uri, "/");
$uriExploded = explode("?",$uri);
$uri = $uriExploded[0];

// Chargement des routes depuis le fichier YAML
if(file_exists("../Routes.yml")) {
    $listOfRoutes = yaml_parse_file("../Routes.yml");
} else {
    header("Internal Server Error", true, 500);
    die("Le fichier de routing ../Routes.yml n'existe pas");
}

if(empty($listOfRoutes[$uri])) {
    header("Status 404 Not Found", true, 404);
    die("Page 404");
}

if(empty($listOfRoutes[$uri]["Controller"]) || empty($listOfRoutes[$uri]["Action"]) ) {
    header("Internal Server Error", true, 500);
    die("Le fichier routes.yml ne contient pas de controller ou d'action pour l'uri :".$uri);
}

$controller = $listOfRoutes[$uri]["Controller"];
$action = $listOfRoutes[$uri]["Action"];

// Vérification d'authentification et des autorisations
// if($listOfRoutes[$uri]["Islog"] && !isLoggedIn()) {
//     // Redirection vers la page de connexion ou autre traitement
//     header("Location: /");
//     exit();
// }

if($listOfRoutes[$uri]["IsAdmin"] && !isAdmin()) {
    // Redirection vers une page d'erreur ou autre traitement
    header("Location: /error403");
    exit();
}

// Inclusion et exécution du contrôleur et de l'action
if(!file_exists("../Controllers/".$controller.".php")){
    die("Le fichier controller ../Controllers/".$controller.".php n'existe pas");
}
include "../Controllers/".$controller.".php";

$controller = "App\\Controller\\".$controller;

if( !class_exists($controller) ){
    die("La class controller ".$controller." n'existe pas");
}
$objetController = new $controller();

if( !method_exists($controller, $action) ){
    die("Le methode ".$action." n'existe pas dans le controller ".$controller);
}
$objetController->$action();

// Fonctions de vérification d'authentification et d'autorisation
function isLoggedIn() {
    // return false;
    // Vérifie si l'utilisateur est connecté et retourne true ou false
}

function isAdmin() {
    // Vérifie si l'utilisateur est administrateur et retourne true ou false
}
