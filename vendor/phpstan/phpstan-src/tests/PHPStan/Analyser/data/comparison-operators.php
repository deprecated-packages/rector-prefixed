<?php

namespace _PhpScoperbd5d0c5f7638\ComparisonOperators;

use function PHPStan\Analyser\assertType;
class ComparisonOperators
{
    public function null() : void
    {
        \PHPStan\Analyser\assertType('false', -1 < null);
        \PHPStan\Analyser\assertType('false', 0 < null);
        \PHPStan\Analyser\assertType('false', 1 < null);
        \PHPStan\Analyser\assertType('false', \true < null);
        \PHPStan\Analyser\assertType('false', \false < null);
        \PHPStan\Analyser\assertType('false', '1' < null);
        \PHPStan\Analyser\assertType('true', 0 <= null);
        \PHPStan\Analyser\assertType('false', '0' <= null);
        \PHPStan\Analyser\assertType('true', null < -1);
        \PHPStan\Analyser\assertType('false', null < 0);
        \PHPStan\Analyser\assertType('true', null < 1);
        \PHPStan\Analyser\assertType('true', null < \true);
        \PHPStan\Analyser\assertType('false', null < \false);
        \PHPStan\Analyser\assertType('true', null < '1');
        \PHPStan\Analyser\assertType('true', null <= '0');
    }
    public function bool() : void
    {
        \PHPStan\Analyser\assertType('true', \true > \false);
        \PHPStan\Analyser\assertType('true', \true >= \false);
        \PHPStan\Analyser\assertType('false', \true < \false);
        \PHPStan\Analyser\assertType('false', \true <= \false);
        \PHPStan\Analyser\assertType('false', \false > \true);
        \PHPStan\Analyser\assertType('false', \false >= \true);
        \PHPStan\Analyser\assertType('true', \false < \true);
        \PHPStan\Analyser\assertType('true', \false <= \true);
    }
    public function string() : void
    {
        \PHPStan\Analyser\assertType('false', 'foo' < 'bar');
        \PHPStan\Analyser\assertType('false', 'foo' <= 'bar');
        \PHPStan\Analyser\assertType('true', 'foo' > 'bar');
        \PHPStan\Analyser\assertType('true', 'foo' >= 'bar');
    }
    public function float() : void
    {
        \PHPStan\Analyser\assertType('true', 1.9 > 1);
        \PHPStan\Analyser\assertType('true', '1.9' > 1);
        \PHPStan\Analyser\assertType('false', 1.9 > 2.1);
        \PHPStan\Analyser\assertType('true', 1.9 > 1.5);
        \PHPStan\Analyser\assertType('true', 1.9 < 2.1);
        \PHPStan\Analyser\assertType('false', 1.9 < 1.5);
    }
    public function unions(int $a, int $b) : void
    {
        if (($a === 17 || $a === 42) && ($b === 3 || $b === 7)) {
            \PHPStan\Analyser\assertType('false', $a < $b);
            \PHPStan\Analyser\assertType('true', $a > $b);
            \PHPStan\Analyser\assertType('false', $a <= $b);
            \PHPStan\Analyser\assertType('true', $a >= $b);
        }
        if (($a === 11 || $a === 42) && ($b === 3 || $b === 11)) {
            \PHPStan\Analyser\assertType('false', $a < $b);
            \PHPStan\Analyser\assertType('bool', $a > $b);
            \PHPStan\Analyser\assertType('bool', $a <= $b);
            \PHPStan\Analyser\assertType('true', $a >= $b);
        }
    }
    public function ranges(int $a, int $b) : void
    {
        if ($a >= 10 && $a <= 20) {
            if ($b >= 30 && $b <= 40) {
                \PHPStan\Analyser\assertType('true', $a < $b);
                \PHPStan\Analyser\assertType('false', $a > $b);
                \PHPStan\Analyser\assertType('true', $a <= $b);
                \PHPStan\Analyser\assertType('false', $a >= $b);
            }
        }
        if ($a >= 10 && $a <= 25) {
            if ($b >= 25 && $b <= 40) {
                \PHPStan\Analyser\assertType('bool', $a < $b);
                \PHPStan\Analyser\assertType('false', $a > $b);
                \PHPStan\Analyser\assertType('true', $a <= $b);
                \PHPStan\Analyser\assertType('bool', $a >= $b);
            }
        }
    }
}
