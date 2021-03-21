<?php
/** @noinspection PhpIncludeInspection */

namespace app\core;

use app\core\Database\DB;
use app\core\Helpers\Bootup;
use app\core\Helpers\FileManager;
use app\core\Http\Http;
use app\core\Routing\Route;

class Main {
    public function __construct() { }

    public function start() {
        // Load enviroment variables and set errors (shown or not)
        Bootup::LOAD_ENV();
        Bootup::SET_ERRORS();

        // Initialize Database first after bootup
        DB::InitializeConnection();

        // Initialize Http for routes
        Http::Initialize();

        // require Routes
        require_once FileManager::fullpath("api/routes.php");

        // validate Routes
        Route::validateUnkownUrl();
    }
}