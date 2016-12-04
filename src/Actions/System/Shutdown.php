<?php
namespace ModernPUG\GarlicBot\Actions\System;

use ModernPUG\GarlicBot\ActionAbstract;
use Slack\ChannelInterface;
use Slack\Payload;

class Shutdown extends ActionAbstract
{
    /** @var \Slack\Payload */
    protected $triggerPayload;
    
    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘아 나갔다와',
            '마늘씨 나가',
            '마늘아 꺼져',
            '마늘님 나가요',
            '마늘 나가',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "나가라고 하면 재부팅해요.";
    }

    /**
     * {@inheritdoc}
     */
    public function action($payload = null)
    {
        $this->triggerPayload = $payload;
        parent::action($payload);
    }

    /**
     * {@inheritdoc}
     */
    public function response(): string
    {
        $this->client->on('message', [$this, 'confirmMessage']);
        return '저 나갈까요? 맞으면 "응"이라고 대답해주세요.';
    }
    
    public function confirmMessage(Payload $payload)
    {
        if (!$this->triggerPayload) {
            $this->client->removeListener('message', [$this, 'confirmMessage']);
            return;
        }
        if ($payload['user'] === $this->triggerPayload['user']) {
            if ($payload['text'] === '응') {
                $this->client->getChannelGroupOrDMByID($payload['channel'])->then(function (ChannelInterface $channel) {
                    $this->client->send('안녕히 계세요오.. ㅠㅠ', $channel)->then(function () {
                        exit;
                    });
                });
            } else {
                $this->client->getChannelGroupOrDMByID($payload['channel'])->then(function (ChannelInterface $channel) {
                    $this->client->send('휴 다행이다.. 진짜로 나가라는 줄 알았어요..', $channel);
                });
                $this->client->removeListener('message', [$this, 'confirmMessage']);
            }
        }
    }
}
