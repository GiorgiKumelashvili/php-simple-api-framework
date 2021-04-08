<?php


namespace app\core\Helpers;

class Helper {
    public static function env(string $env, $default = null): ?string {
        return $_ENV[$env] ?? $default;
    }

    public static function path(): string {
        return $_SERVER['PATH_INFO'] ?? '/';
    }
}