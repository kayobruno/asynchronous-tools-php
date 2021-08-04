<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Chat\Chat;
use App\Chat\Member;
use React\Socket\ConnectionInterface;
use React\Stream\WritableResourceStream;

$loop = React\EventLoop\Loop::get();
$socket = new React\Socket\SocketServer('127.0.0.1:7181', [], $loop);
$stdout = new WritableResourceStream(\STDOUT, $loop);
$chat = new Chat();


$socket->on('connection', static function (ConnectionInterface $connection) use ($chat) {
    $connection->write("Client [{$connection->getRemoteAddress()}] connected \n");

    $member = new Member($connection);
    $member->write('Informe o seu nome: ');

    $connection->on('data', static function ($data) use ($member, $chat) {
        if ($data !== '' && $member->getName() === null) {
            $member->setName(\str_replace(["\r", "\n"], '', $data));
            $chat->addMember($member);
        }
    });
});

$stdout->write("Listening on: {$socket->getAddress()}\n");

$loop->run();
