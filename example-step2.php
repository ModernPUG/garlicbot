<?php
use React\EventLoop\Factory;
use Slack\ChannelInterface;
use Slack\Payload;
use Slack\RealTimeClient;

require __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();

$client = new RealTimeClient($loop);
$client->setToken('xoxb-...');

$client->connect()->then(function () use ($client) {
    $client->on('message', function (Payload $payload) use ($client) {
        if ($payload['text'] === '마늘아') {
            $client->getChannelGroupOrDMByID($payload['channel'])
                ->then(function (ChannelInterface $channel) use ($client) {
                    $client->send("넹", $channel);
                });
        }
    });
});

$loop->run();
