<?php

namespace _PhpScoper26e51eeacccf\StaticMethods;

use function PHPStan\Analyser\assertType;
class Foo
{
    /** @return array<static> */
    public function method()
    {
    }
    /** @return array<static> */
    public function staticMethod()
    {
    }
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', $this->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', $this->method()[0]->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', self::staticMethod());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Foo)>', static::staticMethod());
    }
}
class Bar extends \_PhpScoper26e51eeacccf\StaticMethods\Foo
{
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method()[0]->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', self::staticMethod());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', static::staticMethod());
    }
}
function (\_PhpScoper26e51eeacccf\StaticMethods\Foo $foo, \_PhpScoper26e51eeacccf\StaticMethods\Bar $bar) {
    \PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', $foo->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method()[0]->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', \_PhpScoper26e51eeacccf\StaticMethods\Foo::staticMethod());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', \_PhpScoper26e51eeacccf\StaticMethods\Bar::staticMethod());
};
