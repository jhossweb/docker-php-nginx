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
    private $key;

    function __invoke(Request $req, RequestHandler $handler)
    {
        $token = $req->getHeaderLine("auth-token");
        $this->key = constant("AUTH_JWT");

        if(empty($token)) return new Response(StatusCodeInterface::STATUS_UNAUTHORIZED);

        try {
            
            $decode = JWT::decode($token, new Key($this->key, 'HS256'));
            
            $request = $req->withAttribute("id", $decode->data->id);
            $request = $req->withAttribute("username", $decode->data->username);

            //echo constant("AUTH_JWT");
        } catch (\Exception $e) {
            return new Response (StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $response = $handler->handle($request);
        return $response;
    }
}