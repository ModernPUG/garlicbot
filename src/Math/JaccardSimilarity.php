<?php
namespace ModernPUG\GarlicBot\Math;

class JaccardSimilarity
{
    public function similarity(array $x1, array $x2): float
    {
        $union = [];
        foreach ($x1 as $item) {
            $union[$item] = true;
        }
        foreach ($x2 as $item) {
            $union[$item] = true;
        }
        return count(array_intersect($x1, $x2)) / count($union);
    }
}
