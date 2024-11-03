<?php

namespace App\Users\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController
{
    function index (Request $req, Response $res) {
        $res->getBody()->write("hola mundo");
        return $res;
    }
}