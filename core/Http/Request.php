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
     * Returns and sanitzes requested body data
     * no matter which http method it was
     *
     */
    public function body(): array {
        $body = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            $data = stream_get_contents(fopen('php://input', 'r'));
            $data_assoc = json_decode($data, true) ?? [];

            foreach ($data_assoc as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
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