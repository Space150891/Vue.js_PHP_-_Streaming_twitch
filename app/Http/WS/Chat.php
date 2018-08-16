<?php

namespace App\Http\WS;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    private $connections = [];

    public function onOpen(ConnectionInterface $conn) {
        $this->connections[$conn->resourceId] = compact('conn') + ['user_id' => null];
        \Log::info('open connection');
        $conn->send('connected');
    }

    public function onMessage(ConnectionInterface $from, $msg) {
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}