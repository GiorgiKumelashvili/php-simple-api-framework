<?php

namespace app\core\Database;

use PDO;

final class DB extends Core {
    public function Raw(string $query): array {
        $statement = Core::$connection->query($query);

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
}