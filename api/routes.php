<?php

/*
 * |=============================================
 * | Register Api Methods from controller
 * |============================================
 */

use app\api\controllers\TestController;
use app\core\Routing\Route;


Route::get('/', [TestController::class, 'log']);

// Testing views
Route::view('/test', 'testView');
Route::viewComponent('/test/comp', 'testComponent');


//-------------------[ TEST AREA ]------------------------\\
//echo "<br><br><hr>TEST AREA<hr><br><br>";
//echo "<pre>";
//---------------------------------------------------------\\