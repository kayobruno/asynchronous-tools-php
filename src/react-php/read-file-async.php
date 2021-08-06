<?php

require __DIR__ . '/../../vendor/autoload.php';

use React\EventLoop\Loop;
use React\Stream\ReadableResourceStream;

function run_async($with_echo = false)
{   
    $loop = Loop::get();
    
    $stream = new ReadableResourceStream(
        fopen(__DIR__ .'/numeros.txt', 'rb'), $loop
    );
    
    $stream->on('data', function ($chunk) use ($with_echo) {
        if ($with_echo) echo "$chunk";
    });
    
    $stream->on('end', function () {
        echo 'Memória utilizada: ' . (memory_get_peak_usage(true)/1024/1024) . PHP_EOL;
    });
    
    $loop->run();
}

$print_echo = isset($argv[1]) && $argv[1] === "--echo" ? true : false;

run_async($print_echo);