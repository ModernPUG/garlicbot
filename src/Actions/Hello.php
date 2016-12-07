<?php
namespace ModernPUG\GarlicBot\Actions;

use ModernPUG\GarlicBot\ActionAbstract;

class Hello extends ActionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "인사할 수 있어요.";
    }

    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘아 안녕',
            '마늘씨 안녕하세요',
            '마늘 헬로',
            '마늘 하이',
        ];
    }

    public function response(): string
    {
        return '안녕하세요, 김마늘입니다.';
    }
}
