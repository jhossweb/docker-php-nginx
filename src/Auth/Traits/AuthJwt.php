<?php

namespace App\Auth\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait AuthJwt
{

    function generateToken ( int|string $id, string $username )
    {
        $now = strtotime("now");
        $payload = [
            "data" => [
                "id" => $id,
                "email" => $username
            ],
            "exp" => strtotime("+90 minutes")
        ];

        $jwt = JWT::encode($payload, constant("AUTH_JWT"), "HS256");
        return $jwt;
    }

    function validateToken ($token)
    {
        try {

            $validate = JWT::decode($token, new Key(constant("AUTH_JWT"), "HS256"));
            return $validate;

        } catch (\Exception $e) {
            echo "Error " . $e->getMessage();
            echo "Error en línea -> " . $e->getLine();
            return false;
        }
    }
}