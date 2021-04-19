<?php


namespace app\api\controllers;

use app\core\Http\Request;
use app\core\Http\Response;

class TestController {
    public function log(Request $request, Response $response) {
        $data = $request->validate([
            'message' => 'required'
        ]);

        $response->json([
            'data' => $data
        ]);
    }
}