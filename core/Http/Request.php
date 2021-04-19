<?php

namespace app\core\Http;

final class Request extends ValidateRequest {
    private static ?Request $instance = null;

    public static function Instance(): ?Request {
        if (self::$instance == null) {
            self::$instance = new Request();
        }

        return self::$instance;
    }

    /**
     * Returns requested body data
     * no matter which http method it was
     *
     */
    public function body(): array {
        $file = fopen('php://input', 'r');
        $data = json_decode(stream_get_contents($file), true) ?? [];
        fclose($file);
        return $data;
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

    private function get_status_message(int $statusCode): string {
        $status = [
            '200' => 'OK',
            '201' => 'Created',
            '204' => 'No Content',
            '404' => 'Not Found',
            '406' => 'Not Acceptable',
            '500' => 'Server error'
        ];

        return $status[$statusCode] ?? $status['500'];
    }

}