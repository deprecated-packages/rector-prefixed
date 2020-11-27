<?php

namespace _PhpScoperbd5d0c5f7638\InheritDocParameterRemapping;

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
class Ipsum extends \_PhpScoperbd5d0c5f7638\InheritDocParameterRemapping\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\A', $x);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\B', $y);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\C', $z);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\D', $d);
    }
}
class Dolor extends \_PhpScoperbd5d0c5f7638\InheritDocParameterRemapping\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\A', $g);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\B', $h);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\C', $i);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocParameterRemapping\\D', $d);
    }
}
