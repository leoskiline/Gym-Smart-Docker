<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class PermissionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $permitido = false;
        $route = $request->getAttribute("__route__");
        $group = $route->getGroups()[0];
        if(!empty($_SESSION['permissoes']))
        {
            foreach ($_SESSION['permissoes'] as $permissao)
            {
                if(str_contains($permissao['url'],$group->getPattern()))
                {
                    $permitido = true;
                    break;
                }
            }
        }
        $response = $handler->handle($request);
        if(!$permitido)
        {
            $response = new Response();
            $response->getBody()->write("Você não possui acesso!");
        }
        return $response;
    }
}