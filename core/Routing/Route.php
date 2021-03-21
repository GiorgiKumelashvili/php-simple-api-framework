<?php

namespace app\core\Routing;

use app\core\Helpers\Helper;
use app\core\Http\Http;
use app\core\Http\Response;

final class Route {
    private static array $routes = [];
    private const POST_TYPE = 'POST';
    private const GET_TYPE = 'GET';

    public static function get(string $path, array $params): void {
        self::execute($path, $params, self::GET_TYPE);
    }

    public static function post(string $path, array $params): void {
        self::execute($path, $params, self::POST_TYPE);
    }

    private static function execute(string $path, array $params, string $requestMethod): void {
        self::validateParameters($params);
        self::$routes[$requestMethod][$path] = $params;
        list($className, $methodName) = $params;
        $boolean = false;

        if ($requestMethod === self::GET_TYPE)
            $boolean = Http::$app->request()->isGet();
        elseif ($requestMethod === self::POST_TYPE)
            $boolean = Http::$app->request()->isPost();

        if (self::validateUrl($path) && $boolean)
            self::execArray($className, $methodName);
    }

    private static function validateParameters(array $params) {
        $message = null;

        if (count($params) !== 2)
            $message = "[GIO] Parameters must contain exactly 2 argument";

        if (gettype($params[0]) !== 'string' || gettype($params[1]) !== 'string')
            $message = "[GIO] Arguments must be both string type";

        if ($message)
            Http::$app->response()->Exception($message, Response::ERROR_CODE);
    }

    private static function validateUrl($requestedPath): bool {
        return Helper::rootPath() === $requestedPath;
    }

    private static function execArray(string $className, string $methodName): void {
        if (!method_exists($className, $methodName)) {
            $message = "[GIO] \"{$methodName}()\" method doesn't exists on class \"{$className}\"<br>";
            Http::$app->response()->Exception($message, Response::ERROR_CODE);
        }

        call_user_func([new $className(), $methodName]);
    }

    private static function routes(string $methodType): array {
        return self::$routes[$methodType] ?? [];
    }

    /**
     * Must be last method to run (after registering routes)
     */
    public static function validateUnkownUrl() {
        $currentUrl = Helper::rootPath();
        $methodType = Http::$app->request()->method();

        if (!array_key_exists($currentUrl, self::routes($methodType))) {
            Http::$app
                ->response()
                ->Exception("[GIO] {$methodType} page on \"{$currentUrl}\" Not found", 500);
        }
    }

}