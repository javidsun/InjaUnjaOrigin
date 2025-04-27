<?php

$files = glob(__DIR__ . '/instanceWeb/*.php');

foreach ($files as $file) {
    require $file;
}







