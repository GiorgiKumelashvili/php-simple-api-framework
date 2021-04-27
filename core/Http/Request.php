<?php

namespace app\core\Http;

final class Request extends ValidateRequest {
    public function __construct() { }

    public static function Instance(): Request {
        return new Request();
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

    public function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
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