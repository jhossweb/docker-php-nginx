<?php

namespace App;

use App\Profiles\ProfileRouter;
use App\Users\UserRouter;
use Slim\Factory\AppFactory;

class AppServer
{
    public $app;

    function __construct() {
        $this->app = AppFactory::create();
        
        $this->middlewares();
        $this->router();
        $this->app->run();
    }

    private function middlewares () {
        $this->app->addBodyParsingMiddleware();
    }

    function router() {
        (new UserRouter($this->app))->router;
        (new ProfileRouter($this->app))->router;
    }
}