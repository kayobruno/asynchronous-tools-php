<?php

use Swoole\WebSocket\Frame;
use Swoole\Connection\Iterator;
use Swoole\WebSocket\Server;

$server = new Server('0.0.0.0', 9002);

$server->on('message', function (Server $server, Frame $message) {
    /** @var Iterator $connections */
    $connections = $server->connections;
    $origin = $message->fd;

    foreach ($connections as $connection) {
        if ($connection == $origin) continue;

        $server->push($connection, json_encode(['type' => 'chat', 'text' => $message->data]));
    }
});

$server->start();

