<?php

namespace App\Profiles;

use App\Config\BaseRouter;
use App\Profiles\Controllers\ProfileController;
use App\Utils\Middlewares\TokenMiddleware;

class ProfileRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, ProfileController::class);
    }

    function routes()
    {
        $this->router->get("/profile/{id}", fn($req, $res, $args) => $this->controller->index($req, $res, $args))->add(new TokenMiddleware);
        $this->router->put("/profile/{id}", fn($req, $res, $args) => $this->controller->updateProfileController($req, $res, $args))->add(new TokenMiddleware);
    }
}