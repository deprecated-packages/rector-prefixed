<?php

namespace _PhpScoperabd03f0baf05\Analyser\Bug2574;

use function PHPStan\Analyser\assertType;
abstract class Model
{
    /** @return static */
    public function newInstance()
    {
        return new static();
    }
}
class Model1 extends \_PhpScoperabd03f0baf05\Analyser\Bug2574\Model
{
}
/**
 * @template T of Model
 * @param T $m
 * @return T
 */
function foo(\_PhpScoperabd03f0baf05\Analyser\Bug2574\Model $m) : \_PhpScoperabd03f0baf05\Analyser\Bug2574\Model
{
    \PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    $instance = $m->newInstance();
    \PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    return $instance;
}
function test() : void
{
    \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\Analyser\\Bug2574\\Model1', foo(new \_PhpScoperabd03f0baf05\Analyser\Bug2574\Model1()));
}
