<?php

/*
 * |=============================================
 * | Register Api Methods from controller
 * |============================================
 */

use app\core\Routing\Route;


Route::get('/', [\app\api\controllers\TestController::class, 'log']);
Route::view('/test', 'test');
Route::view('/test/test2', 'test2');
Route::view('/test/inside', 'testdir/inside');


////-------------------[ TEST AREA ]------------------------\\
//echo "<br><br><hr>TEST AREA<hr><br><br>";
////---------------------------------------------------------\\


