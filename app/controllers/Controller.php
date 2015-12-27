<?php
namespace App\Controllers;

class Controller
{
    /**
     * Entry of all controllers and actions;
     * However you can also override it if you want.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $req  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $res  PSR7 response
     * @param  array                                    $args Route parameters
     */
    public function __invoke($request, $response, $args)
    {
         // At frist we should get the action from router.
        $action = strtolower($request->getMethod()) . ucfirst($request->getAttribute('action'));
         // Then if the method is existed, we can call it;
         // Or we should throw \Slim\Exception\NotFoundException.
        if (method_exists($instance = new static, $action)) {
            // Remove {action} from args.
            array_shift($args);
            // Get response body and write it to response.
            $content = call_user_func_array([$instance, $action], $args);
            $response->getBody()->write($content);
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }
}
