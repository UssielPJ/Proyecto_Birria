<?php
class Router {
    private $routes = [];

    function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[$method][$path] = $handler;
    }

    function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $path => $handler) {
            // Convierte la ruta a una expresión regular
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

            // Comprueba si la URI coincide con el patrón
            if (preg_match($pattern, $uri, $matches)) {
                // Extrae los parámetros de la URI
                array_shift($matches);
                $params = $matches;

                // Llama al manejador con los parámetros
                echo call_user_func_array($handler, $params);
                return;
            }
        }

        // Si no se encuentra ninguna ruta
        http_response_code(404);
        echo "404 Not Found";
    }
}