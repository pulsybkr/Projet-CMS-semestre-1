<?php
namespace App\Forms;

class PageRegister
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Créer la page"
            ],
            "inputs" => [
                "page_name" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 100,
                    "placeholder" => "Nom de la page",
                    "required" => true,
                    "error" => "Le nom de la page doit faire entre 2 et 100 caractères"
                ],
                "page_type" => [
                    "type" => "select",
                    "options" => [
                        "home" => "Accueil",
                        "about" => "À propos",
                        "actu" => "Actualités",
                        "galerie" => "Galerie",
                        "contact" => "Contact",
                        "forum" => "Forum"
                    ],
                    "required" => true,
                    "error" => "Le type de page est requis"
                ]
            ]
        ];
    }
}
