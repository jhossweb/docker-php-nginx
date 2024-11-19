<?php

namespace App\Profiles\Controllers;

use App\Auth\Repository\AuthRepository;
use App\Auth\Traits\AuthJwt;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController 
{
    use AuthJwt;

    function __construct(
        private AuthRepository $authRepository = new AuthRepository
    ){}

    function index(Request $req, Response $res, array $args) {
        $data = ["users profile"];
        
        $token = $req->getHeader("auth-token");
        $validateToken = $this->validateToken($token[0]);
        
        $profile = $this->authRepository->findWithRelation($validateToken->data->id, "profile", "user_id");
        
        $res->getBody()->write(json_encode($profile));
        $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }
}