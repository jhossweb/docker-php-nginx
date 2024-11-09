<?php

namespace App\Users\Controllers;

use App\Users\Repository\UserRepository;
use App\Users\Repository\UserRepositroy;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{

    

    function index (Request $req, Response $res) {
        $data = [
            [
                "nombre" => "jhossmer",
                "username" => "jhossweb"
            ],
            [
                "nombre" => "david",
                "username" => "dav&d"
            ]
        ];
        
        $res->getBody()->write(json_encode($data));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res;
    }

    function create(Request $req, Response $res) {
        $users = new UserRepository;
        $users->create(["david"]);

        $res->getBody()->write(json_encode($users));
        $res
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        return $res;
    }
}