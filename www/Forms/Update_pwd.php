<?php
namespace App\Forms;
class Update_pwd
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
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    "required"=>true,
                    "confirm"=>"password",
                    "error"=>"La confirmation ne correspond pas"
                ],
            ]

        ];
    }


}