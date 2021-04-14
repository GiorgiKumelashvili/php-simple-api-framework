<?php

namespace app\core\utils\Arr;

/**
 * Class Arr
 * @package app\core\utils\Arr
 *
 * Wrapper Class for Array High Order Functions
 * e.g. (forEach, filter, map, reduce, some, every, find, findIndex)
 */
class Arr implements ArrayHighOrderFunctions {
    public array $array;

    /**
     * Arr constructor.
     */
    public function __construct(array $array) {
        $this->array = $array;
    }

    /**
     * Arr Object builder
     */
    public static function collect(array $array): Arr {
        return new Arr($array);
    }

    public function forEach(callable $callback): Arr {
        foreach ($this->array as $key => $item) {
            $callback($item, $key);
        }

        return $this;
    }

    public function filter(callable $callback): Arr {
        $this->array = array_filter($this->array, $callback, ARRAY_FILTER_USE_BOTH);
        return $this;
    }

    public function map(callable $callback): Arr {
        $this->array = array_map($callback, $this->array);

        return $this;
    }

    public function reduce(callable $callback) {
        return array_reduce($this->array, $callback);
    }

    public function some(callable $callback): bool {
        foreach ($this->array as $value) {
            if ($callback($value)) {
                return true;
            }
        }

        return false;
    }

    public function every(callable $callback): bool {
        foreach ($this->array as $value) {
            if (!$callback($value)) {
                return false;
            }
        }
        return true;
    }

    public function find(callable $callback) {
        foreach ($this->array as $value) {
            if ($callback($value)) {
                return $value;
            }
        }

        return null;
    }

    public function findIndex(callable $callback): ?int {
        $length = count($this->array);

        for ($i = 0; $i < $length; $i++) {
            if ($callback(array_values($this->array)[$i])) {
                return $i;
            }
        }

        return null;
    }
}

