<?php
namespace ModernPUG\GarlicBot\Providers;

use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Wandu\DI\ContainerInterface;
use Wandu\DI\ServiceProviderInterface;

class ReactServiceProvider implements ServiceProviderInterface 
{
    public function register(ContainerInterface $app)
    {
        $app->closure(LoopInterface::class, function () {
            return Factory::create();
        });
    }

    public function boot(ContainerInterface $app)
    {
    }
}
