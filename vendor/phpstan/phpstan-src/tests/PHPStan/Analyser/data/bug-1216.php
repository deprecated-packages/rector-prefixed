<?php

namespace _PhpScoper26e51eeacccf\Bug1216;

use function PHPStan\Analyser\assertType;
abstract class Foo
{
    /**
     * @var int
     */
    protected $foo;
}
trait Bar
{
    /**
     * @var int
     */
    protected $bar;
    protected $untypedBar;
}
/**
 * @property string $foo
 * @property string $bar
 * @property string $untypedBar
 */
class Baz extends \_PhpScoper26e51eeacccf\Bug1216\Foo
{
    public function __construct()
    {
        \PHPStan\Analyser\assertType('string', $this->foo);
        \PHPStan\Analyser\assertType('string', $this->bar);
        \PHPStan\Analyser\assertType('string', $this->untypedBar);
    }
}
function (\_PhpScoper26e51eeacccf\Bug1216\Baz $baz) : void {
    \PHPStan\Analyser\assertType('string', $baz->foo);
    \PHPStan\Analyser\assertType('string', $baz->bar);
    \PHPStan\Analyser\assertType('string', $baz->untypedBar);
};
