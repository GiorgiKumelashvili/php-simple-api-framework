<?php

namespace app\core\Http;

class Request {
    public function test() {
        echo 'helo from rquest';
    }

    public function getBodyData(): array {
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