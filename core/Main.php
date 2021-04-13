<?php
/** @noinspection PhpIncludeInspection */

namespace app\core;

use app\core\Database\DB;
use app\core\Helpers\Boot;
use app\core\Helpers\FileManager;
use app\core\Routing\Route;

class Main {
    public function __construct() { }

    public function start() {
        // Load environment variables and set errors (shown or not)
        Boot::LOAD_ENV();
        Boot::SET_ERRORS();

        // initialize DB
        DB::Initialize();

        // require Routes
        require_once FileManager::fullpath("api/routes.php");

        // validate Routes
        Route::validateUnkownUrl();
    }
}