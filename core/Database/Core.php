<?php


namespace app\core\Database;

use app\core\Helpers\Helper;
use PDO;
use PDOException;

/**
 * Class Core
 * @package app\core\Database
 */
class Core {
    private static ?object $instance = null;
    private static PDO $connection;

    private function __construct() {
        try {
            $dbhost = Helper::env('DB_HOST');
            $dbname = Helper::env('DB_DATABASE');
            $dbport = Helper::env('DB_PORT');
            $dbusername = Helper::env('DB_USERNAME');
            $dbpassword = Helper::env('DB_PASSWORD');

            $DSN = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";

            // Connect
            $db = new PDO($DSN, $dbusername, $dbpassword, [
                PDO::ATTR_ERRMODE => true,
                PDO::ERRMODE_EXCEPTION => true
            ]);

            self::$connection = $db;
        }
        catch (PDOException $e) {
            die("Connection failed: {$e->getMessage()}");
        }
    }

    protected static function Initialize(): void {
        if (self::$instance == null) {
            self::$instance = new Core();
        }
    }

    public static function connection(): PDO {
        return self::$connection;
    }
}