<?php
namespace ModernPUG\GarlicBot\Math;

/**
 * https://github.com/sjhorn/node-minhash/blob/master/lib/minhash.js * 
 */
class MinHashCalculator
{
    /** @var int */
    protected $prime = 4294967311; // 2^32 next prime

    /** @var array */
    protected $coeffsA = [2070041943, 731886940, 1744484338, 1366614384, 1759730635, 1980516999, 1225398284, 637390653, 289759074, 1867539784, 1161995251, 1700112001, 1712629469, 816721100, 1908211643, 298437595, 2112235630, 332653464, 624020611, 428618264, 1637418095, 379613578, 1850217679, 1934470718, 1054689911, 1722560167, 1081427518, 1593966536, 1573466605, 637834203, 1701041885, 1496024901,];
    
    /** @var array */
    protected $coeffsB = [511812606, 63236557, 1714945166, 1350077330, 2036369072, 1818307962, 739293585, 508705921, 95924419, 1914970415, 42794903, 356827655, 1716673979, 893185287, 1845789130, 1444778005, 1558050315, 1968964588, 2043912901, 1856063457, 1243125230, 1800893591, 32147011, 324211033, 1336311428, 1201314, 1181246180, 1921154754, 631528987, 183957589, 651264507, 1143341593];

    /**
     * @param array $coeffsA
     * @param array $coeffsB
     * @param int $prime
     */
    public function __construct(array $coeffsA = null, array $coeffsB = null, $prime = null)
    {
        if ($coeffsA) {
            $this->coeffsA = $coeffsA;
        }
        if ($coeffsB) {
            $this->coeffsB = $coeffsB;
        }
        if ($prime) {
            $this->prime = $prime;
        }
    }

    /**
     * @param int $hashesCount
     * @param int $randMax default is 2^31
     * @return array
     */
    public static function pickRandomCoeffs($hashesCount, $randMax = 2147483648)
    {
        $randList = [];
        while ($hashesCount--) {
            $randIndex = rand(0, $randMax);
            while (in_array($randIndex, $randList)) {
                $randIndex = rand(0, $randMax);
            }
            $randList[] = $randIndex;
        }
        return $randList;
    }
    
    public function calculate(array $set, $count = 8)
    {
        $signatures = [];
        $prime = $this->prime;
        $coeffsA = $this->coeffsA;
        $coeffsB = $this->coeffsB;
        while ($count--) {
            $minHash = $prime + 1;
            foreach ($set as $element) {
                $minHash = min(
                    ($coeffsA[$count] * crc32($element) + $coeffsB[$count]) % $prime,
                    $minHash
                );
            }
            $signatures[] = $minHash;
        }
        return $signatures;
    }
}
