<?php

namespace app\core\Http;

/**
 * @Singleton Class Http
 * @package app\core\Http
 */
final class Http {
    private static ?Http $instance = null;
    public static Http $app;
    private Request $request;
    private Response $response;

    private function __construct() {
        $this->request = new Request();
        $this->response = new Response();

        self::$app = $this;
    }

    public static function Initialize() {
        if (self::$instance == null) {
            self::$instance = new Http();
        }
    }

    public function request(): Request {
        return $this->request;
    }

    public function response(): Response {
        return $this->response;
    }
}
