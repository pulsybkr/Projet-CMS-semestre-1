<?php
namespace App\Forms;

class PageUpdate
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Enregister les modifications de la page"
            ],
            "inputs" => [
              
            ]
        ];
    }
}
