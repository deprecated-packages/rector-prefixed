<?php

namespace _PhpScoper006a73f0e455\InheritDocParameterRemapping;

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
class Ipsum extends \_PhpScoper006a73f0e455\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\A', $x);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\B', $y);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\C', $z);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \_PhpScoper006a73f0e455\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\A', $g);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\B', $h);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\C', $i);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocParameterRemapping\\D', $d);
    }
}
