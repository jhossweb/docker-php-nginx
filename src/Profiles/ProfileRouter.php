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
        $this->router->get("/profile", fn($req, $res) => $this->controller->index($req, $res));
    }
}