<?php

/*
 * |=============================================
 * | Register Api Methods from controller
 * |============================================
 */

use app\core\Routing\Route;


Route::get('/', [\app\api\controllers\TestController::class, 'log']);