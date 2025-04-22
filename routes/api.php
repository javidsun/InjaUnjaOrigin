<?php

use Illuminate\Support\Facades\Log;

$apiRouteFiles = glob(__DIR__ . '/apiRoutes/*.php');

foreach ($apiRouteFiles as $apiRouteFile) {
    Log::info(basename($apiRouteFile));
    require $apiRouteFile;
}
