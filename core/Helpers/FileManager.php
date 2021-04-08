<?php

namespace app\core\Helpers;

final class FileManager {
    public static function root(): string {
        return dirname(__DIR__, 2) . "/";
    }

    public static function fullpath(string $path): string {
        return dirname(__DIR__, 2) . "/" . $path;
    }

    public static function resourcePath(string $path): string {
        $ssl = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        $root = "{$ssl}://{$_SERVER['HTTP_HOST']}/";

        if (Boot::IN_DEBUG()) {
            return "{$root}scandiweb/client/{$path}";
        }

        return "{$root}client/{$path}";
    }
}