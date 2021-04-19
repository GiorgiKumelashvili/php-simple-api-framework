<?php


namespace app\api\controllers;

use app\core\Http\Request;

class TestController {
    public function log(Request $request) {
        echo $request->method();
    }
}