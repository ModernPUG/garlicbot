<?php
namespace ModernPUG\GarlicBot;

use ModernPUG\GarlicBot\Contracts\ActionInterface;
use Slack\ChannelInterface;
use Slack\Payload;
use Slack\RealTimeClient;

abstract class ActionAbstract implements ActionInterface
{
    /** @var \ModernPUG\GarlicBot\Manager */
    protected $bot;
    
    /** @var \Slack\RealTimeClient */
    protected $client;
    
    public function __construct(RealTimeClient $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Manager $bot)
    {
        $this->bot = $bot;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier(): string
    {
        return static::class;
    }

    public function action($payload = null)
    {
        if ($payload && $payload instanceof Payload) {
            $this->client->getChannelGroupOrDMByID($payload['channel'])->then(function (ChannelInterface $channel) {
                $this->client->send($this->response(), $channel);
            });
        }
    }

    /**
     * @return string
     */
    abstract public function response(): string;
}
