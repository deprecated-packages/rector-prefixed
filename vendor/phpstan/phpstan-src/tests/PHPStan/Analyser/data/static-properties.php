<?php

namespace _PhpScoper88fe6e0ad041\StaticProperties;

use function PHPStan\Analyser\assertType;
class Foo
{
    /** @var array<static> */
    public $prop;
    /** @var array<static> */
    public static $staticProp;
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', $this->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', $this->prop[0]->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', self::$staticProp);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Foo)>', static::$staticProp);
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\StaticProperties\Foo
{
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop[0]->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', self::$staticProp);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', static::$staticProp);
    }
}
function (\_PhpScoper88fe6e0ad041\StaticProperties\Foo $foo, \_PhpScoper88fe6e0ad041\StaticProperties\Bar $bar) {
    \PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', $foo->prop);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', $bar->prop);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', \_PhpScoper88fe6e0ad041\StaticProperties\Foo::$staticProp);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', \_PhpScoper88fe6e0ad041\StaticProperties\Bar::$staticProp);
};
