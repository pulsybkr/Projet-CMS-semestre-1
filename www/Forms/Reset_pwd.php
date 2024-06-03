<?php
namespace App\Forms;
class Reset_pwd
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Valider"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "placeholder"=>"Votre email",
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ]
            ]

        ];
    }


}