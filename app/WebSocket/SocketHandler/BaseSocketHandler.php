<?php

namespace App\WebSocket\SocketHandler;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

abstract class BaseSocketHandler implements MessageComponentInterface
{
    function onOpen(ConnectionInterface $conn)
    {
        dump('open');
    }

    function onClose(ConnectionInterface $conn)
    {
        dump('close');
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        dump('error');
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        dump('message');
    }
}