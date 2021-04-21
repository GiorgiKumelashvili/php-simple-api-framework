<?php

/*
 * |=============================================
 * | Register Api Methods from controller
 * |============================================
 */

use app\api\controllers\TestController;
use app\core\Routing\Route;


Route::get('/m/up', [TestController::class, 'up']);
Route::get('/m/down', [TestController::class, 'down']);

// Testing views
Route::view('/test', 'testView');
Route::viewComponent('/test/comp', 'testComponent');

// todo make ui for migrations instead of routing, cli doesnt work

//-------------------[ TEST AREA ]------------------------\\
//echo "<br><br><hr>TEST AREA<hr><br><br>";
//echo "<pre>";
//---------------------------------------------------------\\