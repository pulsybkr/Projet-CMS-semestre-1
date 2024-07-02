<?php
namespace App\Forms;

class Article
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Publier l article",
                "class" => "form-container"
            ],
            "inputs" => [
                "title" => [
                    "type" => "text",
                    "min" => 5,
                    "max" => 255,
                    "placeholder" => "Titre de l article",
                    "required" => true,
                    "error" => "Le titre doit faire entre 5 et 255 caractères"
                ],
                "content" => [
                    "type" => "textarea",
                    "min" => 20,
                    "max" => 5000,
                    "placeholder" => "Contenu de l article",
                    "required" => true,
                    "error" => "Le contenu doit faire entre 20 et 5000 caractères",
                    "rows" => 10,
                    "cols" => 50,
                    "class" => "textare"
                ],
                "author" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 100,
                    "placeholder" => "Nom de l auteur",
                    "required" => true,
                    "error" => "Le nom de l auteur doit faire entre 2 et 100 caractères"
                ],              
            ]
        ];
    }
}
