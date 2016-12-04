<?php
namespace ModernPUG\GarlicBot\Actions\System;

use ModernPUG\GarlicBot\Contracts\ActionInterface;
use ModernPUG\GarlicBot\Manager;
use Slack\ChannelInterface;
use Slack\RealTimeClient;

class SelfUpdate implements ActionInterface
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
    public function getIdentifier(): string
    {
        return static::class;
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
    public function hears(): array
    {
        return [
            '마늘아 공부해',
            '마늘 바보야',
            '마늘님 공부하세요',
            '마늘씨는 바보!',
            '마늘씨 멍청이!',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "공부하라고 하면 업데이트 할게요.";
    }

    /**
     * {@inheritdoc}
     */
    public function action($payload = null)
    {
        $this->client->getChannelGroupOrDMByID($payload['channel'])->then(function (ChannelInterface $channel) {
            $this->client->send('공부 시작할게요..', $channel)->then(function () use ($channel) {
                exec('git pull origin master');

                exec('/home/gameshuttle/bin/composer install --no-dev -o');
                exec('composer install --no-dev -o');

                $this->client->send('공부 다했어요~ 잠깐 바람좀 쐬고 올게요~', $channel)->then(function () {
                    exit;
                });
            });
        });
    }
}
