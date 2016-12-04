<?php
namespace ModernPUG\GarlicBot\Actions;

use ModernPUG\GarlicBot\ActionAbstract;

class Ping extends ActionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "부르면 그냥 대답해드려요.";
    }

    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘아',
            '마늘씨',
            '마늘',
            '마늘아 죽었니?',
            '마늘아 살았니?',
            '마늘아 있니?',
        ];
    }

    public function response(): string
    {
        return '네 말씀하세요~';
    }
}
