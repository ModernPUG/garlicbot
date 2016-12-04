<?php
namespace ModernPUG\GarlicBot\Providers;

use React\EventLoop\LoopInterface;
use Slack\RealTimeClient;
use Wandu\Config\Contracts\ConfigInterface;
use Wandu\DI\ContainerInterface;
use Wandu\DI\ServiceProviderInterface;

class SlackServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $app)
    {
        $app->closure(RealTimeClient::class, function (LoopInterface $loop, ConfigInterface $config) {
            $client = new RealTimeClient($loop);
            $client->setToken($config['slack.rtm.token']);
            return $client;
        });
    }

    public function boot(ContainerInterface $app)
    {
    }
}
