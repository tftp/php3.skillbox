<?php

namespace Level3\Module2\Task3;

class Application
{

    private $router;
    private $db;

    public function __construct(Router $router, Database $db)
    {
        $this->router = $router;
        $this->db = $db;
    }

    public function run()
    {
        echo $this->router->dispatch($this);
    }

    public function getDatabase()
    {
        return $this->db;
    }

}

class Router
{
    /** @var array|Route[]  */
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes[] = new GetRoute($path, $callback);
    }
    public function post($path, $callback)
    {
        $this->routes[] = new PostRoute($path, $callback);
    }

    public function dispatch(Application $app)
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route) {
            if ($route->match($uri)) {
                return $route->run($app);
            }
        }

        return 'Страница на найдена';
    }
}

abstract class Route
{
    private $path;
    private $callback;

    public function __construct($path, $callback)
    {
        $this->path     = '/' . trim($path, '/');
        $this->callback = $this->prepareCallback($callback);
    }

    private function prepareCallback($callback)
    {
        if (is_callable($callback)) {
            return $callback;
        }

        return function () use ($callback) {
            list($class, $method) = explode('@', $callback);
            return (new $class)->{$method}();
        };
    }

    protected function getPath()
    {
        return $this->path;
    }

    public function match($uri)
    {
        return $_SERVER['REQUEST_METHOD'] == $this->getMethod() && $this->getPath() == $uri;
    }

    public function run(Application $app)
    {
        return call_user_func_array($this->callback, [$app]);
    }

    abstract protected function getMethod();

}

class GetRoute extends Route
{
    protected function getMethod()
    {
        return 'GET';
    }
}

class PostRoute extends Route
{
    protected function getMethod()
    {
        return 'POST';
    }
}

class Database
{
    private $driver;

    public function __construct(DatabaseDriver $driver)
    {
        $this->driver = $driver;
    }

    public function query($sql)
    {
        $this->driver->connect();
        $result = $this->driver->query($sql);
        $this->driver->disconnect();

        return $result;
    }
}


interface DatabaseDriver
{
    public function connect();
    public function query($request);
    public function disconnect();
}

class MysqlDriver implements DatabaseDriver
{
    public function connect()
    {
    }

    public function query($request)
    {
        return [];
    }

    public function disconnect()
    {
    }

}

class ArrayDriver implements DatabaseDriver
{
    public function connect()
    {
    }

    public function query($request)
    {
        return [
            ['name' => 'office 1'],
            ['name' => 'office 2'],
        ];
    }

    public function disconnect()
    {
    }
}

$router = new Router();

$router->get('/', function(Application $app) {
    echo 'HomePage';
});

$router->get('/offices', function(Application $app) {
    $offices = $app->getDatabase()->query('select * from offices');
    var_dump($offices);
});

$app = new Application($router, new Database(new ArrayDriver()));

$app->run();
