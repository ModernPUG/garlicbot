<?php
namespace ModernPUG\GarlicBot\Actions;

use ModernPUG\GarlicBot\ActionAbstract;

class HelloWorld extends ActionAbstract
{
    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return "헬로월드";
    }

    /**
     * {@inheritdoc}
     */
    public function hears(): array
    {
        return [
            '마늘아 재밌는 얘기해줘',
            '마늘아 웃긴얘기',
            '마늘아 잼난 얘기',
            '마늘씨 웃긴얘기',
            '마늘아 심심하다',
        ];
    }

    public function response(): string
    {
        return '어.. 재밌는 이야깋 할 능력이 없어ㅓㅅ..';
    }
}
