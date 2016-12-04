<?php
namespace ModernPUG\GarlicBot\Actions\System;

use ModernPUG\GarlicBot\ActionAbstract;

class Help extends ActionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘이 도움말',
            '마늘이 도움 말',
            '마늘씨 도움!',
            '마늘아 도와줘',
            '마늘씨 도와줘요',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function response(): string
    {
        $messages = [];
        foreach ($this->bot->getActions() as $actionName => $action) {
            $description = $action->description();
            if ($description) {
                $messages[] = $description;
            }
        }
        return "제가 할 수 있는 일은 총 " . count($messages) . "개에요.\n" . " - " . implode("\n - ", $messages);
    }
}
