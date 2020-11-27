<?php

namespace _PhpScoper88fe6e0ad041\ConstExprPhpDocType;

use RecursiveIteratorIterator as Rec;
use function PHPStan\Analyser\assertType;
class Foo
{
    public const SOME_CONSTANT = 1;
    public const SOME_OTHER_CONSTANT = 2;
    /**
     * @param 'foo'|'bar' $one
     * @param self::SOME_* $two
     * @param self::SOME_OTHER_CONSTANT $three
     * @param \ConstExprPhpDocType\Foo::SOME_CONSTANT $four
     * @param Rec::LEAVES_ONLY $five
     * @param 1.0 $six
     * @param 234 $seven
     * @param self::SOME_OTHER_* $eight
     * @param self::* $nine
     */
    public function doFoo($one, $two, $three, $four, $five, $six, $seven, $eight, $nine)
    {
        \PHPStan\Analyser\assertType("'bar'|'foo'", $one);
        \PHPStan\Analyser\assertType('1|2', $two);
        \PHPStan\Analyser\assertType('2', $three);
        \PHPStan\Analyser\assertType('1', $four);
        \PHPStan\Analyser\assertType('0', $five);
        \PHPStan\Analyser\assertType('1.0', $six);
        \PHPStan\Analyser\assertType('234', $seven);
        \PHPStan\Analyser\assertType('2', $eight);
        \PHPStan\Analyser\assertType('1|2', $nine);
    }
}
