<?php
namespace App\Forms;

class ClubRegister
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Créer le club",
                "class" => "form-container"
            ],
            "inputs" => [
                "club_name" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 100,
                    "placeholder" => "Nom du club",
                    "required" => true,
                    "error" => "Le nom du club doit faire entre 2 et 100 caractères"
                ],
                "creation_date" => [
                    "type" => "date",
                    "placeholder" => "Date de création",
                    "required" => true,
                    "error" => "La date de création est requise"
                ],
                "address" => [
                    "type" => "text",
                    "min" => 10,
                    "max" => 255,
                    "placeholder" => "Adresse du club",
                    "required" => true,
                    "error" => "L'adresse doit faire entre 10 et 255 caractères"
                ],
                "phone" => [
                    "type" => "text",
                    "min" => 10,
                    "max" => 15,
                    "placeholder" => "Numéro de téléphone",
                    "required" => true,
                    "error" => "Le numéro de téléphone doit faire entre 10 et 15 caractères"
                ],
                "email" => [
                    "type" => "email",
                    "min" => 8,
                    "max" => 320,
                    "placeholder" => "Email du club",
                    "required" => true,
                    "error" => "L'email doit faire entre 8 et 320 caractères"
                ],
                "website" => [
                    "type" => "url",
                    "max" => 255,
                    "placeholder" => "Site web du club",
                    "required" => false,
                    "error" => "L'URL du site web doit faire au maximum 255 caractères"
                ],
                "logo" => [
                    "type" => "file",
                    "accept" => "image/*",
                    "placeholder" => "Logo du club",
                    "required" => false,
                    "error" => "Le fichier doit être une image valide"
                ],
                "description" => [
                    "type" => "textarea",
                    "min" => 20,
                    "max" => 1000,
                    "placeholder" => "Description du club",
                    "required" => true,
                    "error" => "La description doit faire entre 20 et 1000 caractères",
                    "rows" => 5,
                    "cols" => 33
                ]
            ]
        ];
    }
}
