<?php

namespace App\Users;

use App\Config\BaseRouter;
use App\Users\Controllers\UserController;
use App\Utils\Middlewares\TokenMiddleware;

class UserRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, UserController::class);
    }

    function routes()
    {
        $this->router->get("/", fn($req, $res) => $this->controller->index($req, $res));
        $this->router->get("/users/{id}", fn($req, $res, $args) => $this->controller->findWithRelationController($req, $res, $args))->add(new TokenMiddleware);
        $this->router->post("/users", fn($req, $res) => $this->controller->create($req, $res))->add(new TokenMiddleware);
        $this->router->put("/users/{id}", fn($req, $res, $args) => $this->controller->update($req, $res, $args))->add(new TokenMiddleware);
        $this->router->delete("/users/{id}", fn($req, $res, $args) => $this->controller->delete($req, $res, $args))->add(new TokenMiddleware);
    }
}