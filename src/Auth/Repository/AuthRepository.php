<?php

namespace App\Auth\Repository;

use App\Utils\Model;

class AuthRepository extends Model
{

    protected $table = "users";

    function findByUsernameRepositroy(string|array $username)
    {
        $userSeracrh = $this->findByUsername($username["username"]);
        
        if(!$userSeracrh) return "usuario no encontrado";

        if(!$this->verifyPassword($username["pass"], $userSeracrh["pass"])) return "contraseña no coincide";


        return $userSeracrh;
    }

    function verifyPassword(string $pass, string $passVerify)
    {
        return password_verify($pass, $passVerify);
    }
}