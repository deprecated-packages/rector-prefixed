<?php

namespace _PhpScopera143bcca66cb\InheritDocParameterRemapping;

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
class Ipsum extends \_PhpScopera143bcca66cb\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\A', $x);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\B', $y);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\C', $z);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \_PhpScopera143bcca66cb\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\A', $g);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\B', $h);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\C', $i);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocParameterRemapping\\D', $d);
    }
}
