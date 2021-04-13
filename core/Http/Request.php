<?php

namespace app\core\Http;

final class Request {
    private static ?Request $instance = null;

    public static function Instance(): ?Request {
        if (self::$instance == null) {
            self::$instance = new Request();
        }

        return self::$instance;
    }

    /**
     * Returns requested data
     * no matter which http method it wass
     */
    public function data(): array {
        $req = stream_get_contents(fopen('php://input', 'r'));
        return json_decode($req, true) ?? [];
    }

    public function method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isGet(): bool {
        return $this->method() === 'GET';
    }

    public function isPost(): bool {
        return $this->method() === 'POST';
    }
}