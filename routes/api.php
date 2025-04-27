<?php

$apiRouteFiles = glob(__DIR__ . '/apiRoutes/*.php');

foreach ($apiRouteFiles as $apiRouteFile) {
    require $apiRouteFile;
}
