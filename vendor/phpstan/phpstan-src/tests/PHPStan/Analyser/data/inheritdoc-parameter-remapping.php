<?php

namespace _PhpScoper88fe6e0ad041\InheritDocParameterRemapping;

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
class Ipsum extends \_PhpScoper88fe6e0ad041\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\A', $x);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\B', $y);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\C', $z);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \_PhpScoper88fe6e0ad041\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\A', $g);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\B', $h);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\C', $i);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocParameterRemapping\\D', $d);
    }
}
