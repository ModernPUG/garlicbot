<?php
namespace ModernPUG\GarlicBot\Providers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Wandu\Config\Contracts\ConfigInterface;
use Wandu\DI\ContainerInterface;
use Wandu\DI\ServiceProviderInterface;

class MonologServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $app)
    {
        $app->closure(Logger::class, function (ConfigInterface $config) {
            $logger = new Logger('wandu');
            if ($path = $config['monolog.path']) {
                $logger->pushHandler(new StreamHandler($path));
            }
            return $logger;
        });
        $app->alias(LoggerInterface::class, Logger::class);
    }

    public function boot(ContainerInterface $app)
    {
    }
}
