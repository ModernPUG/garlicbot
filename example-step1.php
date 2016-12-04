<?php
use React\EventLoop\Factory;
use Slack\Payload;
use Slack\RealTimeClient;

require __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

$client = new RealTimeClient($loop);
$client->setToken('xoxb-...');

$client->connect()->then(function () use ($client) {
    $client->on('message', function (Payload $payload) {
        print_r($payload);
    });
});

$loop->run();
