<?php 

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router {
   
    private array $routes = [];
    
    public function __construct(private Container $container) {
    }
    
    public function register(string $route ,string $request_method, array|callable $action): self
    {
        $this->routes[$request_method][$route] = $action;

        return $this;
    }


    public function get(string $route, array|callable $action)
    {
        return $this->register($route, 'GET', $action);
    }


    public function post(string $route, array|callable $action)
    {
        return $this->register($route, 'POST', $action);
    }

    public function resolve(string $request_method, string $request_uri)
    {
        $route = explode('?', $request_uri)[0];

        $method = $request_method;

        $action = $this->routes[$method][$route] ?? null;


        if (! $action) {
            throw new RouteNotFoundException("404 Route not found");
        }

        if(is_callable($action)) {
            call_user_func_array($action, []);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $controller = $this->container->get($class);

                if (method_exists($controller, $method)) {

                    return call_user_func([$controller, $method], []);
                }
            }

        }

        throw new RouteNotFoundException();
        
    }

    public function routes(): array
    {
        return $this->routes;
    }


}