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

    public function put(string $path, callable|array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable|array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
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
    if (!isset($this->routes[$method])) {
        return false;
    }

    foreach ($this->routes[$method] as $route => $handler) {

        // Convert /{id} into a dynamic route pattern
        $pattern = preg_replace(
            '#\{[^/]+\}#',
            '([^/]+)',
            $route
        );

        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $path, $matches)) {

            array_shift($matches);

            call_user_func(
                $handler,
                ...$matches
            );

            return true;
        }
    }

    return false;
}
}