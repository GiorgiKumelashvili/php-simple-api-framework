<?php

namespace app\core\Helpers;

use Dotenv\Dotenv;

class Boot {
    /**
     * Loads enviroment variables if website host is localhost
     * this is for Dotenv package
     *
     * @return void
     */
    public static function LOAD_ENV(): void {
        $rootPath = FileManager::root();
        $dotenv = Dotenv::createImmutable($rootPath);

        if ($_SERVER['HTTP_HOST'] === 'localhost') {
            $dotenv->load();
        }
    }

    /**
     * If APP_DEBUG in environment variables is true
     * then errors will be shown
     *
     * @return void
     */
    public static function SET_ERRORS(): void {
        ini_set('display_errors', self::IN_DEBUG() ? 1 : 0);
    }


    /**
     * Checks if web is in debug mode (e.g. development mode)
     *
     * @return bool
     */
    public static function IN_DEBUG(): bool {
        $isDebugging = Helper::env('APP_DEBUG');
        return filter_var($isDebugging, FILTER_VALIDATE_BOOLEAN);
    }
}