<?php
namespace ModernPUG\GarlicBot\Providers;

use Wandu\Config\Contracts\ConfigInterface;
use Wandu\DI\ContainerInterface;
use Wandu\DI\ServiceProviderInterface;
use Wandu\Mecab\Mecab;

class MecabServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $app)
    {
        $app->closure(Mecab::class, function (ConfigInterface $config) {
            return new Mecab($config['mecab.dict_path']);
        });
    }

    public function boot(ContainerInterface $app)
    {
    }
}
