<?php

namespace app\core\Helpers;
use Dotenv\Dotenv;

class Bootup {
    public static function LOAD_ENV(): void {
        $rootPath = FileManager::root();
        $dotenv = Dotenv::createImmutable($rootPath);
        $dotenv->load();
    }


    /**
     * If APP_DEBUG in enviroment variables is true
     * then erros will be shown
     */
    public static function SET_ERRORS(): void {
        $isDebugging = Helper::env('APP_DEBUG');
        $bool = filter_var($isDebugging, FILTER_VALIDATE_BOOLEAN);

        ini_set('display_errors', $bool ? 1 : 0);
    }
}