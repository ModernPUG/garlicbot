<?php
namespace ModernPUG\GarlicBot\Contracts;

use ModernPUG\GarlicBot\Manager;

interface ActionInterface
{
    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @return string
     */
    public function description(): string;

    /**
     * @param \ModernPUG\GarlicBot\Manager $botKit
     */
    public function boot(Manager $botKit);

    /**
     * @return string[]
     */
    public function hears(): array;

    /**
     * @return string
     */
    public function response(): string;
}
