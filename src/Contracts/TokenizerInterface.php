<?php
namespace ModernPUG\GarlicBot\Contracts;

interface TokenizerInterface
{
    /**
     * @param string $text
     * @return string[]
     */
    public function tokenize(string $text): array;
}
