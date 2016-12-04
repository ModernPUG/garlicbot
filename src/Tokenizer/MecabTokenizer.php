<?php
namespace ModernPUG\GarlicBot\Tokenizer;

use ModernPUG\GarlicBot\Contracts\TokenizerInterface;
use Wandu\Mecab\Mecab;

class MecabTokenizer implements TokenizerInterface
{
    /** @var \Wandu\Mecab\Mecab */
    protected $mecab;

    /**
     * @param \Wandu\Mecab\Mecab $mecab
     */
    public function __construct(Mecab $mecab)
    {
        $this->mecab = $mecab;
    }

    /**
     * {@inheritdoc}
     */
    public function tokenize(string $text): array
    {
        $text = preg_replace('/[^가-힣]*/', '', $text);
        return $this->mecab->split($text);
    }
}
