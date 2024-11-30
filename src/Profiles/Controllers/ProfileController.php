<?php

namespace App\Profiles\Controllers;

use App\Auth\Repository\AuthRepository;
use App\Auth\Traits\AuthJwt;
use App\Profiles\Repository\ProfileRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController 
{
    use AuthJwt;

    function __construct(
        private AuthRepository $authRepository = new AuthRepository,
        private ProfileRepository $profileRepository = new ProfileRepository
    ){}

    function index(Request $req, Response $res, array $args) {
               
        $token = $req->getHeader("auth-token");
        $validateToken = $this->validateToken($token[0]);
        $profile = $this->profileRepository->findOneRepository($validateToken->data->id);
        

        $res->getBody()->write(json_encode($profile));
        $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }

    function updateProfileController(Request $req, Response $res){
        $token = $req->getHeader("auth-token");
        $validateToken = $this->validateToken($token[0]);
        $data = $req->getParsedBody();

        $updated = $this->profileRepository->updateProfileRepository($validateToken->data->id, $data);
        if(!$updated) { 
            $res->getBody()->write("no se actualizó");
            $res    
                ->withHeader("Content-Type", "application/json")
                ->withStatus(404);
        }

        $res->getBody()->write(json_encode($updated));
        $res    
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
        return $res;
    }
}