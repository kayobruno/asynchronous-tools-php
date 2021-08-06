<?php

require __DIR__ . '/../../vendor/autoload.php';

function run_sync($memory_limit = false)
{
    if ($memory_limit) ini_set('memory_limit', '12M');

    file_get_contents(__DIR__ .'/numeros.txt');
    
    echo 'Memória utilizada: ' . (memory_get_peak_usage(true)/1024/1024) . PHP_EOL;
}

$memory_limit = isset($argv[1]) && $argv[1] === "--memory-limit" ? true : false;


run_sync($memory_limit);