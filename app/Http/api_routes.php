<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/





Route::resource('posts', 'PostAPIController');

Route::resource('wusers', 'WuserAPIController');