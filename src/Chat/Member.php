<?php

declare(strict_types=1);

namespace App\Chat;

use Closure;
use React\Socket\ConnectionInterface;

final class Member
{
    private $name;
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function write(string $data) : void
    {
        $data = \str_replace(["\r", "\n"], '', $data);

        $this->connection->write($data . \PHP_EOL);
    }

    public function onData(Closure $handler) : void
    {
        $this->connection->on('data', $handler);
    }

    public function onClose(Closure $handler) : void
    {
        $this->connection->on('close', $handler);
    }
}
