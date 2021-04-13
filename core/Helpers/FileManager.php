<?php

namespace app\core\Helpers;

final class FileManager {
    public static function root(): string {
        return dirname(__DIR__, 2) . "/";
    }

    public static function fullpath(string $path): string {
        return dirname(__DIR__, 2) . "/" . $path;
    }
}