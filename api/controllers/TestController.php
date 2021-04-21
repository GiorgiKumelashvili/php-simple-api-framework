<?php


namespace app\api\controllers;

use app\core\Database\Migration;

class TestController {
    public function up() {
        echo "<pre>";

        $mig = new Migration();
        $mig->migrate();
    }

    public function down() {
        echo "<pre>";

        $mig = new Migration();
        $mig->drop();
    }
}