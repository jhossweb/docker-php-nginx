<?php

namespace App\Utils\Middlewares;

use Fig\Http\Message\StatusCodeInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class TokenMiddleware
{
    private $key = "jhossweb";

    function __invoke(Request $req, RequestHandler $handler)
    {
        $token = $req->getHeaderLine("auth-token");
        if(empty($token)) return new Response("no existe token");

        try {
            
            $decode = JWT::decode($token, new Key($this->key, 'HS256'));
            var_dump($decode);
            $request = $req->withAttribute("id", $decode->data->id);
            $request = $req->withAttribute("username", $decode->data->username);

        } catch (\Exception $e) {
            return new Response (StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $response = $handler->handle($request);
        return $response;
    }
}