<?php
namespace ModernPUG\GarlicBot;

use ModernPUG\GarlicBot\Contracts\ActionInterface;

abstract class ActionAbstract implements ActionInterface
{
    /** @var \ModernPUG\GarlicBot\Manager */
    protected $botKit;
    
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
    public function boot(Manager $botKit)
    {
        $this->botKit = $botKit;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier(): string
    {
        return static::class;
    }
}
