<?php

namespace _PhpScoper26e51eeacccf\InheritDocParameterRemapping;

use function PHPStan\Analyser\assertType;
class Lorem
{
    /**
     * @param B $b
     * @param C $c
     * @param A $a
     * @param D $d
     */
    public function doLorem($a, $b, $c, $d)
    {
    }
}
class Ipsum extends \_PhpScoper26e51eeacccf\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\A', $x);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\B', $y);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\C', $z);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \_PhpScoper26e51eeacccf\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\A', $g);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\B', $h);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\C', $i);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocParameterRemapping\\D', $d);
    }
}
