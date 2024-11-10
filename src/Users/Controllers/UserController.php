<?php

namespace App\Users\Controllers;

use App\Users\Repository\UserRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{

    function __construct(
        private UserRepository $userRepository = new UserRepository
    ){}

    function index (Request $req, Response $res) {
        $users = $this->userRepository->findRepository();
        
        $res->getBody()->write(json_encode($users));
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
        $id = $args["id"];
        $userUpdated = $this->userRepository->update($id, $req->getParsedBody());

        $res->getBody()->write(json_encode($userUpdated));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res;
    }

    function delete(Request $req, Response $res, array $args) {
        $id = $args["id"];
        
        $userDelete = $this->userRepository->deleteRepository($id);
        $res->getBody()->write(json_encode($userDelete));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res;
    }
}