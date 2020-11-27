<?php

namespace _PhpScoperbd5d0c5f7638\StaticMethods;

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
class Bar extends \_PhpScoperbd5d0c5f7638\StaticMethods\Foo
{
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', $this->method()[0]->method());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', self::staticMethod());
        \PHPStan\Analyser\assertType('array<static(StaticMethods\\Bar)>', static::staticMethod());
    }
}
function (\_PhpScoperbd5d0c5f7638\StaticMethods\Foo $foo, \_PhpScoperbd5d0c5f7638\StaticMethods\Bar $bar) {
    \PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', $foo->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', $bar->method()[0]->method());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Foo>', \_PhpScoperbd5d0c5f7638\StaticMethods\Foo::staticMethod());
    \PHPStan\Analyser\assertType('array<StaticMethods\\Bar>', \_PhpScoperbd5d0c5f7638\StaticMethods\Bar::staticMethod());
};
