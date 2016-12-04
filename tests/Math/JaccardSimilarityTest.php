<?php
namespace ModernPUG\GarlicBot\Math;

use PHPUnit_Framework_TestCase;

class JaccardSimilarityTest extends PHPUnit_Framework_TestCase
{
    public function testSimilarity()
    {
        $x1 = [0, 1, 2, 5, 6];
        $x2 = [0, 2, 3, 5, 7, 9];

        $jaccard = new JaccardSimilarity();

        static::assertEquals(0.375, $jaccard->similarity($x1, $x2));

        shuffle($x1);
        shuffle($x2);

        static::assertEquals(0.375, $jaccard->similarity($x1, $x2));
    }
}
