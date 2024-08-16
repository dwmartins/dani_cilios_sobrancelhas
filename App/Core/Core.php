<?php

namespace App\Core;

use App\Http\Request;

class Core {
    public static function dispatch(array $routes) {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $prefixController = 'App\\Controllers\\';

        $routesFound = false;

        foreach($routes as $route) {
            $pattern = '#^'. preg_replace('/{id}/', '([\w-]+)', $route['path'] . '$#'); 

            if(preg_match($pattern, $url, $matches)) {
                array_shift($matches);

                $routesFound = true;

                if ($_SERVER['REQUEST_METHOD'] !== $route['method']) {
                    continue;
                }

                [$controller, $action] = explode('@', $route['action']); 

                $controller = $prefixController . $controller;

                if (!class_exists($controller) || !method_exists($controller, $action)) {
                    self::handleRouteNotFound($controller, $action);
                    return;
                }

                $extendController = new $controller();
                $result = $extendController->$action(new Request, $matches);

                if (is_array($result) && isset($result['view']) && isset($result['data'])) {
                    extract($result['data']);
                    $view = $result['view'];

                    $masterLayout = self::getMasterLayout($url);
                    require __DIR__ . "/../views/" . $masterLayout;
                }
                return;
            }
        }

        if (!$routesFound) {
            self::routeNotFoundResponse($url);
        } else {
            self::methodNotAllowedResponse($url);
        }
    }

    private static function getMasterLayout($url) {
        if (strpos($url, '/app') !== false) {
            return 'admin/master.php';
        } else {
            return 'public/master.php';
        }
    }

    private static function methodNotAllowedResponse($url) {
        logError('The "' . $_SERVER['REQUEST_METHOD'] . '" method is not allowed in "' . $url . '"');
        http_response_code(405);
        echo "The (" . $_SERVER['REQUEST_METHOD'] . ") method is not allowed in ($url)";
    }

    private static function routeNotFoundResponse($url) {
        logError("Route not found: $url");
        http_response_code(404);
        echo "Sorry, route not found.";
    }

    private static function handleRouteNotFound($controller, $action) {
        logError("Class or method not found: $controller@$action");
        http_response_code(500);
        echo "Class or method not found for this route.";
    }
}
