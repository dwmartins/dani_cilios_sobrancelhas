<?php

use App\Http\Route;

Route::get('/contato', 'ContactController@index');
Route::post('/contato', 'ContactController@sendMessage');