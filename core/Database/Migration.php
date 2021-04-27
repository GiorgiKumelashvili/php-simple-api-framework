<?php

/**
 * @noinspection
 * PhpMissingParentConstructorInspection,
 * SqlNoDataSourceInspection,
 * SqlResolve,
 * PhpIncludeInspection
 * PhpInconsistentReturnPointsInspection
 */

namespace app\core\Database;

use app\core\Helpers\FileManager;
use app\core\Http\Response;
use PDO;

class Migration extends Core {
    private string $migrationsFolderName;
    private string $migrationTableName;

    public function __construct(
        string $migrationsFolderName = 'Migrations',
        string $migrationTableName = 'migrations'
    ) {
        $this->migrationsFolderName = $migrationsFolderName;
        $this->migrationTableName = $migrationTableName;
    }

    public function migrate() {
        // first create migrations
        $this->createMigrationsTable();

        // if migration is present in $mustApplyMigrations then up will be called
        $appliedMigrations = $this->getAppliedMigrations();
        $mustApplyMigrations = array_diff($this->getMigrationFiles(), $appliedMigrations);
        $newMigrations = [];

        // get namespace to load migrations
        $migrationNamespace = $this->getNamespaceForMigrations();

        // call up methods in migrations
        foreach ($mustApplyMigrations as $applyMigration) {
            if ($applyMigration === '.' || $applyMigration === '..') {
                continue;
            }

            $this->callUpMethod($migrationNamespace, $applyMigration, 1);
            $newMigrations[] = $applyMigration;
        }

        // save migrations in DB if $newMigrations is not empty
        if (empty($newMigrations)) {
            $this->log("There are no migrations to apply");
        }
        else {
            $this->saveMigrations($newMigrations);
        }
    }

    public function drop() {
        // if migration is present then drop method will be called
        $mustDropMigrations = $this->getAppliedMigrations();

        // get namespace to load migrations
        $migrationNamespace = $this->getNamespaceForMigrations();
        $mustRemoveMigrations = [];

        // call up methods in migrations
        foreach ($mustDropMigrations as $applyMigration) {
            if ($applyMigration === '.' || $applyMigration === '..') {
                continue;
            }

            $this->callUpMethod($migrationNamespace, $applyMigration, 2);
            $mustRemoveMigrations[] = $applyMigration;
        }

        // remove migrations from DB if $mustRemoveMigrations is not empty
        if (empty($mustRemoveMigrations)) {
            $this->log("There are no migrations to drop");
        }
        else {
            $this->removeMigrations($mustRemoveMigrations);
        }
    }

    private function createMigrationsTable() {
        self::$connection->query("
            CREATE TABLE IF NOT EXISTS {$this->migrationTableName} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
            ENGINE=INNODB;
        ");
    }

    private function getAppliedMigrations(): array {
        // no need to check if migrations table exists because it will always exist
        $statement = self::$connection->prepare("SELECT migration FROM {$this->migrationTableName}");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getMigrationFiles(): array {
        $path = FileManager::fullpath("{$this->migrationsFolderName}");
        if (is_dir($path)) {
            return scandir($path);
        }
        else {
            $message = "Migrations file name is incorrect or doesnt exist";
            Response::Instance()->errorMessage($message);
        }
    }

    private function getNamespaceForMigrations(): string {
        $coreNamespace = explode('\\', __NAMESPACE__)[0];
        return "\\{$coreNamespace}\\{$this->migrationsFolderName}\\";
    }

    private function log(string $message): void {
        $date = date("Y-m-d H:i:s");
        echo "[$date] $message \n";
    }

    private function callUpMethod(string $migrationNamespace, string $applyMigration, int $type = 1) {
        $newMigratioClassName = $migrationNamespace . pathinfo($applyMigration, PATHINFO_FILENAME);
        $newMigration = new $newMigratioClassName;

        if ($type === 1) {
            $this->log("Applying migration $applyMigration");
            $newMigration->up();
            $this->log("Applied migration $applyMigration");
        }
        else {
            $this->log("Dropping Migration");
            $newMigration->down();
            $this->log("Dropped Migration");
        }
    }

    private function saveMigrations(array $newMigrations) {
        $mig_values = implode(',', array_map(fn($m) => "('{$m}')", $newMigrations));

        $statement = self::$connection->prepare("
            INSERT INTO {$this->migrationTableName} 
                (migration) 
            VALUES 
                {$mig_values}
        ");

        $statement->execute();
    }

    private function removeMigrations(array $mustRemoveMigrations) {
        $mig_values = implode(',', array_map(fn($m) => "'{$m}'", $mustRemoveMigrations));

        $statement = self::$connection->prepare("
            DELETE FROM {$this->migrationTableName} 
            WHERE
                  migration
            IN 
                  ({$mig_values})
        ");

        $statement->execute();
    }
}