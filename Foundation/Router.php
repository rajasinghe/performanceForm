<?php


require "./Foundation/Route.php";

class Router
{
    public static $route;
    public static SplObjectStorage $POST;
    public static SplObjectStorage $GET;
    public static $requestMethod;
    public static function listenToRouteChange()
    {
        //new request object which.
        self::$requestMethod = $_SERVER['REQUEST_METHOD'];
        $request = new Request();
        //full url
        $uri = $_SERVER['REQUEST_URI'];

        //remove the parameter part from the url

        $urlPath = parse_url($uri, PHP_URL_PATH);
        self::$route = $urlPath;

        //the validate route returns a callback function and then the request is then injected to the callback

        if (self::$requestMethod == 'GET') {
            self::validateRoute(self::$GET)($request);
        } else if (self::$requestMethod == 'POST') {
            $data = $request->getRequestBody();
            self::validateRoute(self::$POST)($request);
        } else {
        }
    }
    public static function validateParameterizedRoute($route, $url)
    {
        $parameterIdentifierRegex = '/{([\w]+)}/';
        $variableNames = [];
        $valuesMatches = [];
        $values = [];
        $variables = [];
        $routeRegex = null;
        //array wich holds the names of the variables which needed to be created later

        //need to create the variables based on the parameterized route (not incoming route defined route)
        if (preg_match_all($parameterIdentifierRegex, $route, $variableNames)) {
            $variableNames = $variableNames[1];
            //route regex for matching the incoming url route and extract the data from the url
            $routeRegex = "/^" . preg_replace([$parameterIdentifierRegex, '/\//'], ['(\w+)', '\/'], $route) . "$/";

            if (preg_match_all($routeRegex, $url, $valuesMatches)) {

                /* echo $routeRegex . '</br>';
                print_r($variableNames) . '-</br>';
                print_r($valuesMatches);
                echo '</br>' . $url . '</br>'; */
                $parametersArguments = [];


                for ($i = 1; $i < count($valuesMatches); $i++) {
                    $values[] = $valuesMatches[$i][0];
                }

                for ($i = 0; $i < count($variableNames); $i++) {
                    $variableName = $variableNames[$i];
                    $value = $values[$i];
                    $parametersArguments[$variableName] = $value;
                }
                return $parametersArguments;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    public static function validateRoute($requestArray)
    {
        $requestArray->rewind();
        while ($requestArray->valid()) {
            $routeInstance = $requestArray->current();
            //matches the route with the incoming route 
            //path parameters must me be checked here
            //if the current route instance on the loop has path parameters the validation goes beyond just checking equality
            if ($parametersArguments = self::validateParameterizedRoute($routeInstance->route, self::$route)) {
                //validate the parameterizedRoute
                if ($parametersArguments && is_array($parametersArguments) && count($parametersArguments) > 0) {
                    //return the callback function
                    return self::handleParameterizedCallaback($routeInstance->callback, $parametersArguments);
                }
            } else {
                //not a parameterized route
                if ($routeInstance->route == self::$route) {
                    return self::handleCallaback($routeInstance->callback);
                }
            }
            $requestArray->next();
        }
        //no match has found 
        return self::handleRouteNotFoundException();
    }
    public static function handleCallaback($callback)
    {
        if (is_array($callback)) {
            return function ($requestParam) use ($callback) {
                $controllerInstance = new $callback[0]();
                $callbackFunctionName = $callback[1];
                $controllerInstance->$callbackFunctionName($requestParam);
            };
        } else {
            return $callback;
        }
    }
    public static function handleParameterizedCallaback($callback, $arguments)
    {
        if (is_array($callback)) {
            return function ($requestParam) use ($callback, $arguments) {
                $controllerInstance = new $callback[0]();
                $callbackFunctionName = $callback[1];

                //$controllerInstance->$callbackFunctionName($requestParam, extract($arguments));
                array_unshift($arguments, $requestParam);
                call_user_func_array([$controllerInstance, $callbackFunctionName], $arguments);
            };
        } else {
            return function ($requestParam) use ($callback, $arguments) {
                //$callback($requestParam, extract($arguments));
                array_unshift($arguments, $requestParam);
                call_user_func_array($callback, array_values($arguments));
            };
        }
    }
    public static function get($route, $callback)
    {
        //store the route information in the the splStorageObject
        //echo var_dump($callback);
        //self::$GET[$path] = $callback;
        self::$GET->attach(self::createRoute($route, $callback));
    }
    public  static function post($route, $callback)
    {
        self::$POST->attach(self::createRoute($route, $callback));
    }
    public static function initializeRouter()
    {
        header("Access-Control-Allow-Origin: *");
        self::initializeRouteStorage();
        require './Routes/Routes.php';
        self::listenToRouteChange();
    }
    public static function createRoute($route, $callback)
    {
        return $route = new Route($route, $callback);
    }

    public static function initializeRouteStorage()
    {
        self::$GET = new SplObjectStorage();
        self::$POST = new SplObjectStorage();
    }

    public static function handleRouteNotFoundException()
    {
        return function ($request) {
            if (self::$requestMethod == "POST")
                echo "<div>Route not found</div>";
        };
    }
}
