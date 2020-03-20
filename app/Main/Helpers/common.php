<?php

use App\Main\Registry;
use App\Http\Exceptions\Exception;
use App\Main\Http\Exceptions\AppException;

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header('Location: ' . $url);
    }
}

if (!function_exists('view')) {
    function view($view, $data = null)
    {
        return (new App\Main\Controller)->render($view, $data);
    }
}

if (!function_exists('simpleView')) {
    function simpleView($view, $data = null)
    {
        return (new App\Main\Controller)->singleRender($view, $data);
    }
}

if (!function_exists('response')) {
    function response()
    {
        return new \App\Main\DataResponse;
    }
}

if (!function_exists('ApiResponse')) {
    function ApiResponse($data)
    {
        return (new App\Main\Http\ApiResponseResource)->handle($data);
    }
}

if (!function_exists('sendMessage')) {
    function sendMessage($message, $code = null)
    {
        return (new App\Main\Http\ApiResponseResource)->message($message, $code);
    }
}

if (!function_exists('session')) {
    function session($key, $value = null)
    {
        $session = (new App\Main\Session);
        if ($value !== null) {
            $session->$key = $value;
            return true;
        } elseif ($value === null) {
            return $session->$key;
        }
        die('Syntax wrong !');
    }
}

if (!function_exists('unsetsession')) {
    function unsetsession($key)
    {
        return App\Main\Session::unset_session($key);
    }
}

if (!function_exists('request')) {
    function request()
    {
        return new \App\Main\Http\Request;
    }
}

if (!function_exists('readDotENV')) {
    function readDotENV()
    {
        $app_url = dirname(dirname(dirname(dirname(__FILE__))));
        $path = $app_url . '/.env';
        if (!file_exists($path)) {
            throw new \Exception("Env doesn't exists !");
        }
        $handle = file_get_contents($path);
        $paze = explode("\n", $handle);
        foreach ($paze as $key => $value) {
            $vl[$key] = explode("=", $value);
            if (isset($vl[$key][0]) && isset($vl[$key][1])) {
                $env[$vl[$key][0]] = $vl[$key][1];
            }
        }
        return $env;
    }
}
if (!function_exists('env')) {
    function env($variable, $ndvalue = null)
    {
        $env = readDotENV();
        foreach ($env as $key => $value) {
            if ($variable == $key) {
                $result = preg_replace('/\s+/', '', $value);
                if (!empty($result)) {
                    return $result;
                }
                break;
            }
        }
        return $ndvalue;
    }
}

if (!function_exists('config')) {
    function config($variable)
    {
        $paze = explode('.', $variable);
        if (count($paze) != 2) {
            throw new Exception("The {$variable} doesn't exists !");
        }
        if (!$url = env('APP_URL', dirname(dirname(dirname(dirname(__FILE__))))) . "/config/{$paze[0]}.php") {
            throw new Exception("The $url doesn't exists !");
        } else {
            $config = require $url;
        }
        return $config[$paze[1]];
    }
}

if (!function_exists('action')) {
    function action($action, array $params = null)
    {
        return Registry::getInstance()->route->callableAction($action, $params);
    }
}

if (!function_exists('route')) {
    function route(string $name)
    {
        $routes = app()->routes;
        $flag = false;
        $uri = '';
        foreach ($routes as $key => $route) {
            if (strtolower($name) === strtolower($route['name'])) {
                $flag = true;
                $uri = $route['uri'];
            }
        }
        if ($flag === true) {
            echo $uri;
        } else {
            throw new Exception("The route " . '"' . $name . '"' . " doesn't exists");
        }
    }
}

if (!function_exists('toPre')) {
    function toPre($collection): void
    {
        echo '<pre>';
        print_r($collection);
        echo '</pre>';
        exit;
    }
}

if (!function_exists('app')) {
    function app()
    {
        return Registry::getInstance();
    }
}

if (!function_exists('is_json')) {
    function is_json($argument)
    {
        return (json_decode(json_encode($argument)) != NULL) ? true : false;
    }
}

if (!function_exists('dd')) {
    function dd($arg)
    {
        var_dump($arg);
        die();
    }
}

if (!function_exists('assets')) {
    function assets($path)
    {
        if (php_sapi_name() == 'cli-server') {
            return "/public/$path";
        } else {
            return $path;
        }
        throw new Exception("");
    }
}