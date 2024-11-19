<?php

namespace App\Auth\Controllers;

use App\Auth\Repository\AuthRepository;
use App\Auth\Traits\AuthJwt;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController
{
    use AuthJwt;

    function __construct(
        private AuthRepository $authRepository = new AuthRepository
    ){}

    function signin (Request $req, Response $res) {
        $user = $req->getParsedBody();
        
        $userSigin = $this->authRepository->findByUsernameRepositroy($user);

        $token = $this->generateToken($userSigin["id"], $userSigin["username"]);
        
        $res->getBody()->write(json_encode($userSigin));
        $res = $res
           ->withHeader('Content-Type', 'application/json')
           ->withHeader("auth-token", $token)
           ->withStatus(200);
       return $res;
    }
}