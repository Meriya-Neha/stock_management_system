<?php

namespace src\Routes;

class Router
{
    private array $routes = [];

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function group(string $prefix, array $routes): void
    {
        foreach ($routes as $method => $paths) {
            foreach ($paths as $path => $handler) {
                $this->routes[$method][$prefix . $path] = $handler;
            }
        }
    }

    public function dispatch(string $method, string $path): bool
    {
        if (isset($this->routes[$method][$path])) {
            call_user_func($this->routes[$method][$path]);
            return true;
        }

        return false;
    }
}