<?php


namespace app\core\Http;


class Response {
    public const ERROR_CODE = 404;

    public function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function Exception(string $message, int $statusCode): void {
        http_response_code($statusCode);
        echo $message;
        die();
    }
}