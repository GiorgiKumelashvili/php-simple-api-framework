<?php


namespace app\core\Helpers;

class Helper {
    public static function env(string $env): ?string {
        return $_ENV[$env] ?? null;
    }

    public static function rootPath(): string {
        return $_SERVER['PATH_INFO'] ?? '/';
    }
}