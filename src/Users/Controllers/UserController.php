<?php

namespace App\Users\Controllers;

use App\Auth\Traits\AuthJwt;
use App\Users\Repository\UserRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{
    use AuthJwt;
    
    function __construct(
        
        private UserRepository $userRepository = new UserRepository
    ){}


    function index (Request $req, Response $res) {
        $users = $this->userRepository->findAll();
        
        $res->getBody()->write(json_encode($users));
        $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }

    function findByController(Request $req, Response $res, array $args) {
        $userBy = $this->userRepository->findByRepository($args["id"]);

        $res->getBody()->write(json_encode($userBy));
        $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }

    function findWithRelationController(Request $req, Response $res, array $args) {
        
        $user = $this->userRepository->findWithRelationRepository("profile", "user_id", $args['id']);
        
        $res->getBody()->write(json_encode($user));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res; 
    }

    function create(Request $req, Response $res) {
       
        $user_id = $this->userRepository->createRepository($req->getParsedBody());
        

       $res->getBody()->write(json_encode($user_id));
       $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }

    function update(Request $req, Response $res, array $args) {
        $token = $req->getHeader("auth-token");
        $validateToken = $this->validateToken($token[0]);
        $data = $req->getParsedBody();


        $userUpdated = $this->userRepository->updateRepository($validateToken->data->id, $data);

        $res->getBody()->write(json_encode($userUpdated));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res;
    }

    // function delete(Request $req, Response $res, array $args) {
    //     $id = $args["id"];
        
    //     $userDelete = $this->userRepository->deleteRepository($id);
    //     $res->getBody()->write(json_encode($userDelete));
    //     $res
    //         ->withHeader('Content-Type', 'application/json')
    //         ->withStatus(200);
    //     return $res;
    // }
}