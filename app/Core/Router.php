<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get(string $path, string $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, string $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);

        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $route => $handler) {

            // Chuyển {id}, {slug} thành tham số URL
            $pattern = preg_replace_callback(
                '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
                function ($matches) {
                    return '([^/]+)';
                },
                $route
            );

            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {

                array_shift($matches);

                [$controllerName, $action] = explode('@', $handler);

                $class = 'App\\Controllers\\' . $controllerName;

                if (!class_exists($class)) {
                    http_response_code(500);
                    exit('Controller không tồn tại: ' . $class);
                }

                $controller = new $class();

                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    exit(
                        "Phương thức {$action} không tồn tại trong {$controllerName}."
                    );
                }

                // Giải mã tham số URL
                $params = array_map('urldecode', $matches);

                $controller->$action(...$params);

                return;
            }
        }

        http_response_code(404);
        echo '404 - Không tìm thấy trang.';
    }
}
