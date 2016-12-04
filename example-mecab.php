<?php
use Wandu\Mecab\Mecab;

require __DIR__ .'/vendor/autoload.php';

$mecab = new Mecab('/usr/local/lib/mecab/dic/mecab-ko-dic');

print_r($mecab->split('마늘아 밥 추천좀'));
