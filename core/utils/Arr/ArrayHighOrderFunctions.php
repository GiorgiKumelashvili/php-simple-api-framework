<?php


namespace app\core\utils\Arr;

interface ArrayHighOrderFunctions {
    public function filter(callable $callback): Arr;

    public function forEach(callable $callback): Arr;

    public function map(callable $callback): Arr;

    public function reduce(callable $callback);

    public function some(callable $callback): bool;

    public function every(callable $callback): bool;

    public function find(callable $callback);

    public function findIndex(callable $callback): ?int;
}