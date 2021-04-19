<?php


namespace app\core\Http;


final class Response {
    private static ?Response $instance = null;
    public const ERROR_CODE = 404;

    public static function Instance(): ?Response {
        if (self::$instance == null) {
            self::$instance = new Response();
        }

        return self::$instance;
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