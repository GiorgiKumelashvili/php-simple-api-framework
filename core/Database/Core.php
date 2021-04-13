<?php


namespace app\core\Database;

use app\core\Helpers\Helper;
use PDO;
use PDOException;

class Core {
    private static ?PDO $connection = null;
    private static ?Core $instance = null;

    private function __construct() {
        try {
            $dbhost = Helper::env('DB_HOST');
            $dbname = Helper::env('DB_DATABASE');
            $dbport = Helper::env('DB_PORT');
            $dbusername = Helper::env('DB_USERNAME');
            $dbpassword = Helper::env('DB_PASSWORD');

            $DSN = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";

            // Connect
            self::$connection = new PDO($DSN, $dbusername, $dbpassword, [
                PDO::ATTR_ERRMODE => true,
                PDO::ERRMODE_EXCEPTION => true
            ]);
        }
        catch (PDOException $e) {
            die("Connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Main function for initializing object and $connection
     * which is most important one, if Database name is not
     * provided then Initialization wont happen
     */
    public static function Initialize(): void {
        if (self::$instance === null) {
            self::$instance = new Core();
        }
    }

    /**
     * Returns database connection which will always
     * be inititalized ony once
     *
     * @return PDO
     */
    protected static function connection(): PDO {
        return self::$connection;
    }
}