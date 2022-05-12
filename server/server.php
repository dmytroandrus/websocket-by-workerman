<?php

use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';

$webSocket = new Worker('websocket://0.0.0.0:2346');
$webSocket->count = 4;
$webSocket->onConnect = function ($connection) {
  echo 'new connection';
};
$webSocket->onMessage = function ($connection, $data) use ($webSocket) {
  foreach ($webSocket->connections as $clientConnection) {
    $clientConnection->send($data);
  }
};
$webSocket->onClose = function ($connection) {
  echo 'connection closed';
};

Worker::runAll();
