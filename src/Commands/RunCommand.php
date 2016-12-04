<?php
namespace ModernPUG\GarlicBot\Commands;

use ModernPUG\GarlicBot\Manager;
use React\EventLoop\LoopInterface;
use Slack\RealTimeClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    /** @var \ModernPUG\GarlicBot\Manager */
    protected $bot;

    /** @var \Slack\RealTimeClient */
    protected $client;
    
    /** @var \React\EventLoop\LoopInterface */
    protected $loop;
    
    public function __construct(Manager $bot, RealTimeClient $client, LoopInterface $loop)
    {
        parent::__construct();
        $this->bot = $bot;
        $this->client = $client;
        $this->loop = $loop;
    }

    protected function configure()
    {
        $this->setName('run');
        $this->setDescription('run commands');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Index...");
        $this->bot->index();
        $output->writeln("Index Complete!");

        $output->writeln("Run Garlic Bot...");
        $this->bot->execute($this->client);
        $this->loop->run();
    }
}
