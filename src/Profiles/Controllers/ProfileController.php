<?php

namespace App\Profiles\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController 
{
    function index(Request $req, Response $res) {
        $data = ["users profile"];

        $res->getBody()->write(json_encode($data));
        $res
           ->withHeader('Content-Type', 'application/json')
           ->withStatus(200);
       return $res;
    }
}