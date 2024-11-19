<?php

namespace App\Profiles;

use App\Config\BaseRouter;
use App\Profiles\Controllers\ProfileController;

class ProfileRouter extends BaseRouter
{
    function __construct($app)
    {
        parent::__construct($app, ProfileController::class);
    }

    function routes()
    {
        $this->router->get("/profile/{id}", fn($req, $res, $args) => $this->controller->index($req, $res, $args));
    }
}