<?php


namespace app\api\controllers;


use app\core\Http\Response;

class TController {
    public function test(Response $response) {
        $response->json([
            'hello' => 123
        ]);
    }
}