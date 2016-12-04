<?php
namespace ModernPUG\GarlicBot\Math;

use PHPUnit_Framework_TestCase;

class MinHashCalculatorTest extends PHPUnit_Framework_TestCase
{
    public function testHello()
    {
        $minHash = new MinHashCalculator();

        static::assertEquals(
            [538969110, 2166844944, 2212025535, 339106914, 3177680915, 1688869424, 686727629, 543661744],
            $minHash->calculate(['kkk', '하하하하', '젠장'])
        );
        static::assertEquals(
            [538969110, 989735464, 2212025535, 1641351783, 198177386, 1688869424, 557480768, 543661744],
            $minHash->calculate(['kkk', '후후후후', '젠장'])
        );
    }
}
