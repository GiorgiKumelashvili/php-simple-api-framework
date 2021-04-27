<?php
/** @noinspection PhpIncludeInspection */

namespace app\core\Routing;

use app\core\Helpers\FileManager;
use app\core\Helpers\Helper;
use app\core\Helpers\View;
use app\core\Http\Response;
use ReflectionClass;
use ReflectionException;

final class Route {
    private static array $routes = [];
    private const POST_TYPE = 'POST';
    private const GET_TYPE = 'GET';

    /**
     * Get route method, usually used for viewing pages
     */
    public static function get(string $path, array $params): void {
        self::execute($path, $params, self::GET_TYPE);
    }

    /**
     * Post route method, usually used for api purposes
     */
    public static function post(string $path, array $params): void {
        self::execute($path, $params, self::POST_TYPE);
    }

    /**
     * View route method, used for viwing plain php file
     * with no asssistance
     */
    public static function view(string $path, string $viewName): void {
        self::$routes[self::GET_TYPE][$path] = $viewName;

        if (self::validateUrl($path)) {
            require_once FileManager::fullpath("api/view/$viewName.php");
        }
    }

    /**
     * View Component route method, used for viwing php file with
     * asssistance of html boilerplate
     */
    public static function smartView(string $path, string $viewName): void {
        self::$routes[self::GET_TYPE][$path] = $viewName;

        if (self::validateUrl($path)) {
            echo View::head_HTML(Helper::env('APP_NAME'));
            require_once FileManager::fullpath("api/view/$viewName.php");
            echo View::bottom_HTML();
        }
    }

    /**
     * Validates parameters, adds paths to routes, checks http
     * method and execute registered methods by classname and method
     */
    private static function execute(string $path, array $params, string $requestMethod): void {
        self::validateParameters($params);

        // register routes
        self::$routes[$requestMethod][$path] = $params;

        // destructure
        list($className, $methodName) = $params;

        // execute method
        if (self::validateUrl($path))
            self::execArray($className, $methodName);
    }

    /**
     * Validate so that correct parameters are given
     * 2 argument and both must be string
     */
    private static function validateParameters(array $params) {
        if (count($params) !== 2)
            Response::Instance()->exception(
                "[SERVER] Parameters must contain exactly 2 argument",
                Response::_SERVER_ERROR
            );

        if (gettype($params[0]) !== 'string' || gettype($params[1]) !== 'string')
            Response::Instance()->exception(
                "[SERVER] Arguments must be both string type",
                Response::_SERVER_ERROR
            );
    }

    /**
     * Checks if requested path is same as current url path
     */
    private static function validateUrl($requestedPath): bool {
        return Helper::path() === $requestedPath;
    }

    /**
     * Here method is executed by creating new object
     */
    private static function execArray(string $className, string $methodName): void {
        if (!method_exists($className, $methodName)) {
            Response::Instance()->exception(
                "[SERVER] \"$methodName()\" method doesn't exists on class \"$className\"<br>",
                Response::_SERVER_ERROR
            );
        }

        self::callMethod($className, $methodName);
    }

    /**
     * For now it can only inject Request and Response objects, nothing else
     * Method is called with Reflection magic
     *
     * @param string $className
     * @param string $methodName
     */
    private static function callMethod(string $className, string $methodName): void {
        try {
            $reflectionClass = new ReflectionClass($className);
            $method = $reflectionClass->getMethod($methodName);

            // check if parameters are present
            if ($method->getNumberOfParameters()) {
                // Object array which will be injected into method as parameters
                $objects = array();

                // Create and register objects using reflection class
                foreach ($method->getParameters() as $parameter) {
                    $finalClassName = (string)$parameter->getType();
                    $objects[] = new $finalClassName;
                }

                // Call method by injecting objects inside as parameters
                call_user_func_array([new $className(), $methodName], $objects);
            }
            else {
                // Just Call method
                call_user_func([new $className(), $methodName]);
            }
        }
        catch (ReflectionException $e) {
            Response::Instance()->json([
                "message" => "Somethig went wrong (ReflectionException)",
                "error" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Self explanatory
     */
    private static function routes(string $methodType): array {
        return self::$routes[$methodType] ?? [];
    }

    /**
     * Must be last method to run (after registering routes)
     * validates if requested route is registered in static routes
     */
    public static function validateUnkownUrl() {
        $currentUrl = Helper::path();
        $methodType = $_SERVER['REQUEST_METHOD'];

        if (!array_key_exists($currentUrl, self::routes($methodType))) {
            Response::Instance()->exception(
                "[SERVER] $methodType page on \"$currentUrl\" Not found",
                Response::_NOT_FOUND
            );
        }
    }
}