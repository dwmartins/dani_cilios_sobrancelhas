<?php

require_once __DIR__ ."/../vendor/autoload.php";
require_once __DIR__."/../loadConfig.php";
require_once __DIR__."/../App/Routes/main.php";

use App\Core\Core;
use App\Http\Route;

Core::dispatch(Route::routes());
