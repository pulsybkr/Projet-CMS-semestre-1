<?php
namespace App\Forms;
class Register
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"S'inscrire",
                "class" => "form-container"
                ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "placeholder"=>"Votre email",
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],
            ]

        ];
    }


}