<?php

namespace _PhpScoperabd03f0baf05\Bug1924;

use function PHPStan\Analyser\assertType;
class Bug1924
{
    function getArrayOrNull() : ?array
    {
        return \rand(0, 1) ? [1, 2, 3] : null;
    }
    function foo() : void
    {
        $arr = ['a' => $this->getArrayOrNull(), 'b' => $this->getArrayOrNull()];
        \PHPStan\Analyser\assertType('array(\'a\' => array|null, \'b\' => array|null)', $arr);
        $cond = isset($arr['a']) && isset($arr['b']);
        \PHPStan\Analyser\assertType('bool', $cond);
    }
}
