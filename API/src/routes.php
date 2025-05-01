<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/MarcaController.php';
require_once __DIR__ . '/controllers/PrendaController.php';
require_once __DIR__ . '/controllers/VentaController.php';
require_once __DIR__ . '/controllers/DetalleVentaController.php';
require_once __DIR__ . '/controllers/ReporteController.php';

class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $path = '/' . trim($path, '/');
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
            'pattern' => '@^' . preg_replace('/\{[a-z]+\}/', '([^/]+)', $path) . '$@i'
        ];
    }

    public function handleRequest($method, $path) {
        $path = '/' . trim($path, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                $params = array_slice($matches, 1);
                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Ruta no encontrada',
            'path' => $path,
            'available_routes' => array_column($this->routes, 'path')
        ]);
    }
}

$router = new Router();

// ====================== RUTAS CRUD ======================
// Usuarios
$router->addRoute('GET', '/usuarios', ['UsuarioController', 'getAll']);
$router->addRoute('GET', '/usuarios/{id}', ['UsuarioController', 'getById']);
$router->addRoute('POST', '/usuarios', ['UsuarioController', 'create']);
$router->addRoute('PUT', '/usuarios/{id}', ['UsuarioController', 'update']);
$router->addRoute('DELETE', '/usuarios/{id}', ['UsuarioController', 'delete']);

// Clientes
$router->addRoute('GET', '/clientes', ['ClienteController', 'getAll']);
$router->addRoute('GET', '/clientes/{id}', ['ClienteController', 'getById']);
$router->addRoute('POST', '/clientes', ['ClienteController', 'create']);
$router->addRoute('PUT', '/clientes/{id}', ['ClienteController', 'update']);
$router->addRoute('DELETE', '/clientes/{id}', ['ClienteController', 'delete']);

// Marcas
$router->addRoute('GET', '/marcas', ['MarcaController', 'getAll']);
$router->addRoute('GET', '/marcas/{id}', ['MarcaController', 'getById']);
$router->addRoute('POST', '/marcas', ['MarcaController', 'create']);
$router->addRoute('PUT', '/marcas/{id}', ['MarcaController', 'update']);
$router->addRoute('DELETE', '/marcas/{id}', ['MarcaController', 'delete']);

// Prendas
$router->addRoute('GET', '/prendas', ['PrendaController', 'getAll']);
$router->addRoute('GET', '/prendas/{id}', ['PrendaController', 'getById']);
$router->addRoute('POST', '/prendas', ['PrendaController', 'create']);
$router->addRoute('PUT', '/prendas/{id}', ['PrendaController', 'update']);
$router->addRoute('DELETE', '/prendas/{id}', ['PrendaController', 'delete']);

// Ventas
$router->addRoute('GET', '/ventas', ['VentaController', 'getAll']);
$router->addRoute('GET', '/ventas/{id}', ['VentaController', 'getById']);
$router->addRoute('POST', '/ventas', ['VentaController', 'create']);
$router->addRoute('PUT', '/ventas/{id}', ['VentaController', 'update']);
$router->addRoute('DELETE', '/ventas/{id}', ['VentaController', 'delete']);

// DetalleVenta
$router->addRoute('GET', '/detalle-ventas', ['DetalleVentaController', 'getAll']);
$router->addRoute('GET', '/detalle-ventas/{id}', ['DetalleVentaController', 'getById']);
$router->addRoute('POST', '/detalle-ventas', ['DetalleVentaController', 'create']);
$router->addRoute('PUT', '/detalle-ventas/{id}', ['DetalleVentaController', 'update']);
$router->addRoute('DELETE', '/detalle-ventas/{id}', ['DetalleVentaController', 'delete']);

// Reportes
$router->addRoute('GET', '/reportes/marcas-con-ventas', ['ReporteController', 'getMarcasConVentas']);
$router->addRoute('GET', '/reportes/prendas-stock', ['ReporteController', 'getPrendasStock']);
$router->addRoute('GET', '/reportes/top5-marcas', ['ReporteController', 'getTop5Marcas']);

// CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    http_response_code(200);
    exit;
}
?>