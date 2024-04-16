<?php
namespace App\Core;
class Security
{

    public function isLogged(): bool
    {
        return false;
    }

    public function isFirstLog(): bool
    {
        return false;
    }


}