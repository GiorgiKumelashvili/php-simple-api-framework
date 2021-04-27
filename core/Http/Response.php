<?php


namespace app\core\Http;


final class Response {
    public const _NOT_FOUND = 404;
    public const _SERVER_ERROR = 500;

    public function __construct() { }

    public static function Instance(): Response {
        return new Response();
    }

    public function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }

    public function errorMessage($data, array $otherMessages = []) {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $data,
            ...$otherMessages
        ]);
        die();
    }

    public function exception(string $message, int $statusCode): void {
        http_response_code($statusCode);
        echo $message;
        die();
    }
}