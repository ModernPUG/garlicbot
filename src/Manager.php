<?php
namespace ModernPUG\GarlicBot;

use ModernPUG\GarlicBot\Contracts\ActionInterface;
use ModernPUG\GarlicBot\Contracts\StorageInterface;
use Psr\Log\LoggerInterface;
use Slack\ChannelInterface;
use Slack\Payload;
use Slack\RealTimeClient;
use Slack\User;

class Manager
{
    const VERSION = 'v0.0.1';
    
    /** @var \ModernPUG\GarlicBot\Contracts\StorageInterface */
    protected $storage;
    
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;
    
    /** @var \ModernPUG\GarlicBot\Contracts\ActionInterface[] */
    protected $actions;
    
    /** @var \Slack\User */
    protected $me;

    public function __construct(StorageInterface $storage, LoggerInterface $logger)
    {
        $this->storage = $storage;
        $this->logger = $logger;
    }

    /**
     * @param \ModernPUG\GarlicBot\Contracts\ActionInterface $action
     * @return $this
     */
    public function addAction(ActionInterface $action): Manager
    {
        $this->actions[$action->getIdentifier()] = $action;
        return $this;
    }

    /**
     * @return \ModernPUG\GarlicBot\Contracts\ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }
    
    /**
     * @param \Slack\RealTimeClient $client
     */
    public function execute(RealTimeClient $client)
    {
        $client->connect()->then(function () use ($client) {
            return $client->getAuthedUser();
        })->then(function (User $user) use ($client) {
            $this->me = $user;
            foreach ($this->actions as $action) {
                $action->boot($this);
            }
            $this->loadMessage($client);
        });
    }

    public function index()
    {
        $this->storage->clear();
        foreach ($this->actions as $actionName => $action) {
            $this->storage->store($action);
        }
    }

    /**
     * @param \Slack\RealTimeClient $client
     */
    protected function loadMessage(RealTimeClient $client)
    {
        if ($this->logger) {
            $this->logger->info('start listen message');
        }
        
        $client->on('message', function (Payload $payload) use ($client) {
            $user = $payload['user'];
            $text = $payload['text'];

            // 내가 한 말은 무시.
            if ($user === $this->me->getId()) return;

            // 마늘이 안들어가면 실행하지 않음.
            if (strpos($text, '마늘') === false) return;

            $action = $this->storage->search($text);
            if ($action) {
                $this->logger->debug("[{$action} 실행됨.]");
                $this->actions[$action]->action($payload);
            } else {
                $this->logger->debug("[실행할 명령어가 없음.]");
            }
        });
    }
}
