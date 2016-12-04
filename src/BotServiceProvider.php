<?php
namespace ModernPUG\GarlicBot;

use ModernPUG\GarlicBot\Contracts\StorageInterface;
use ModernPUG\GarlicBot\Contracts\TokenizerInterface;
use ModernPUG\GarlicBot\Storage\FileStorage;
use ModernPUG\GarlicBot\Tokenizer\MecabTokenizer;
use Wandu\DI\ContainerInterface;
use Wandu\DI\ServiceProviderInterface;

class BotServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $app)
    {
        $app->bind(TokenizerInterface::class, MecabTokenizer::class);
        $app->bind(StorageInterface::class, FileStorage::class);
    }

    public function boot(ContainerInterface $app)
    {
    }
}
