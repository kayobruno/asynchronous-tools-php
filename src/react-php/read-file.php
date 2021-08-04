<?php

require __DIR__ . '/../../vendor/autoload.php';

//ini_set('memory_limit', '12M');

//$content = file_get_contents(__DIR__ .'/numeros.txt');
//echo 'Memória utilizada: ' . (memory_get_peak_usage(true)/1024/1024) . PHP_EOL;
// Memória utilizada: 77.24

use React\EventLoop\Loop;
use React\Stream\ReadableResourceStream;

$loop = Loop::get();

$stream = new ReadableResourceStream(
    fopen(__DIR__ .'/numeros.txt', 'rb'), $loop
);

$stream->on('data', function ($chunk) {
    echo "$chunk";
});

$stream->on('end', function () {
    echo 'Memória utilizada: ' . (memory_get_peak_usage(true)/1024/1024) . PHP_EOL;
});

$loop->run();

// Memória utilizada: 2
