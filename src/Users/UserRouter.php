<?php

namespace App\Users;

use App\Config\BaseRouter;
use App\Users\Controllers\UserController;

class UserRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, UserController::class);
    }

    function routes()
    {
        $this->router->get("/", fn($req, $res) => $this->controller->index($req, $res));
        $this->router->get("/users", fn($req, $res) => $this->controller->create($req, $res));
    }
}