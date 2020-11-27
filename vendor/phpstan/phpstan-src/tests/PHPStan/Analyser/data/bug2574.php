<?php

namespace _PhpScoperbd5d0c5f7638\Analyser\Bug2574;

use function PHPStan\Analyser\assertType;
abstract class Model
{
    /** @return static */
    public function newInstance()
    {
        return new static();
    }
}
class Model1 extends \_PhpScoperbd5d0c5f7638\Analyser\Bug2574\Model
{
}
/**
 * @template T of Model
 * @param T $m
 * @return T
 */
function foo(\_PhpScoperbd5d0c5f7638\Analyser\Bug2574\Model $m) : \_PhpScoperbd5d0c5f7638\Analyser\Bug2574\Model
{
    \PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    $instance = $m->newInstance();
    \PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    return $instance;
}
function test() : void
{
    \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\Analyser\\Bug2574\\Model1', foo(new \_PhpScoperbd5d0c5f7638\Analyser\Bug2574\Model1()));
}
