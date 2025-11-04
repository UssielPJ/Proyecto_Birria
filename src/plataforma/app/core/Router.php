<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (empty($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found (no routes for $method)";
            return;
        }

        foreach ($this->routes[$method] as $path => $handler) {
            // convierte {id} en grupos regex
            $parts = explode('/', trim($path, '/'));
            $patternParts = [];
            foreach ($parts as $part) {
                if (preg_match('/^\{[^}]+\}$/', $part)) {
                    $patternParts[] = '([^/]+)';
                } else {
                    $patternParts[] = preg_quote($part, '#');
                }
            }
            $pattern = '#^/' . implode('/', $patternParts) . '/?$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // quita coincidencia completa
                $params = $matches;

                $callback = $this->resolveHandler($handler);

                if (!$callback) {
                    throw new \Exception("Invalid route handler for $path");
                }

                echo call_user_func_array($callback, $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Convierte strings tipo "Controller@method" a [objeto, 'method'].
     * Si ya es callable, lo devuelve igual.
     */
    private function resolveHandler($handler): ?callable {
        if (is_callable($handler)) {
            return $handler;
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controller, $method] = explode('@', $handler, 2);
            // Agrega namespace si no lo tiene
            if (strpos($controller, '\\') === false) {
                $controller = 'App\\Controllers\\' . $controller;
            }

            if (class_exists($controller)) {
                $instance = new $controller();
                if (method_exists($instance, $method)) {
                    return [$instance, $method];
                }
            }
        }

        return null;
    }
}
