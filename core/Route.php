<?php

    class Route {
        private static $routes = [];

        public static function add($method, $path, $callback, $middlewares = []) {
            // Convertir les paramètres dynamiques {param} en expressions régulières
            $path = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
            $path = "#^" . $path . "$#";

            self::$routes[] = compact('method', 'path', 'callback', 'middlewares');
        }
        public static function redirect($path) {
            header("Location: $path");
            exit();
        }
        
        public static function dispatch() {
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
            foreach (self::$routes as $route) {
                if ($method === $route['method'] && preg_match($route['path'], $uri, $matches)) {
                    // Extraire les paramètres dynamiques de l'URL
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        
                    // Vérifier les middlewares
                    foreach ($route['middlewares'] as $middleware) {
                        if (!call_user_func([new $middleware, 'handle'], $params)) {
                            return; // Middleware bloque l'exécution
                        }
                    }
        
                    // Instancier le contrôleur avec ses dépendances
                    list($controllerClass, $controllerMethod) = $route['callback'];
        
                    // **Ajouter la connexion à la base de données ici**
                    
                    require_once __DIR__. '/../models/connexion.php';
                    $conn = Database::getInstance()->getConnection();
                    $controller = new $controllerClass($conn);
        
                    // Appeler la méthode du contrôleur avec les paramètres
                    call_user_func_array([$controller, $controllerMethod], [$params]);
                    return;
                }
            }
        
            // Si aucune route ne correspond
            // http_response_code(404);
            // echo "404 Not Found";
            require_once __DIR__ . '/../views/404.php';
        }
        
    }
