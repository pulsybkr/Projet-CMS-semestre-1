<?php

namespace App;
use Firebase\JWT\JWT; 
use Firebase\JWT\Key;

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    echo 'Erreur lors du chargement du fichier .env: ' . $e->getMessage();
    exit(1);
}

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
if($listOfRoutes[$uri]["Islog"] && isLoggedIn()){
    // Redirection vers la page de connexion ou autre traitement
    header("Location: /");
    exit();
}

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
    $cookieName = "esgi_cc";
    if (isset($_COOKIE[$cookieName])) {
        $token = $_COOKIE[$cookieName];
        
        try {
            // Vérifier si le token est valide en le décodant
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
            
            // Vérifier si le token a expiré
            if ($decoded->exp < time()) {
                // Le token a expiré
                return false;
            }
            
            // Le token est valide
            return true;
        } catch (Exception $e) {
            // Une exception s'est produite lors du décodage du token
            return false;
        }
    }
    
    // Le cookie n'existe pas
    return false;
}

function isAdmin() {
    // Vérifie si l'utilisateur est administrateur et retourne true ou false
}
