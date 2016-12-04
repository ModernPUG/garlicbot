<?php
use ModernPUG\GarlicBot\Commands\RunCommand;
use ModernPUG\GarlicBot\Manager;
use Symfony\Component\Console\Application;
use Wandu\Config\Config;
use Wandu\Config\Contracts\ConfigInterface;
use Wandu\DI\Container;

$autoloadPath = realpath(__DIR__);
while (!file_exists($autoloadPath . '/vendor/autoload.php')) {
    if ($autoloadPath == '/' || !$autoloadPath) {
        echo "cannot find autoload.php. you may run composer install.\n";
        exit(-1);
    }
    $autoloadPath = dirname($autoloadPath);
}

chdir($autoloadPath);

require_once 'vendor/autoload.php';

$cli = new Application('Garlic Bot CLI', Manager::VERSION);
if (!file_exists('.garlicbot.php')) {
    echo "cannot find .garlicbot.php. copy .garlicbot.sample.php\n";
    exit(-1);
}

require '.garlicbot.php';

// container
$container = new Container();
$container->instance(Config::class, $config = new Config(require 'app/config.php'));
$container->alias(ConfigInterface::class, Config::class);

date_default_timezone_set($config->get('timezone', 'UTC'));

foreach (require 'app/providers.php' as $provider) {
    $container->register(new $provider());
}
$container->boot();

$bot = $container->get(Manager::class);
foreach (require 'app/actions.php' as $actionName) {
    $bot->addAction($container->create($actionName));
}

$cli->addCommands([
    $container->create(RunCommand::class)
]);
$cli->run();
