<?php

namespace _PhpScopera143bcca66cb\StaticProperties;

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
class Bar extends \_PhpScopera143bcca66cb\StaticProperties\Foo
{
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', $this->prop[0]->prop);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', self::$staticProp);
        \PHPStan\Analyser\assertType('array<static(StaticProperties\\Bar)>', static::$staticProp);
    }
}
function (\_PhpScopera143bcca66cb\StaticProperties\Foo $foo, \_PhpScopera143bcca66cb\StaticProperties\Bar $bar) {
    \PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', $foo->prop);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', $bar->prop);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Foo>', \_PhpScopera143bcca66cb\StaticProperties\Foo::$staticProp);
    \PHPStan\Analyser\assertType('array<StaticProperties\\Bar>', \_PhpScopera143bcca66cb\StaticProperties\Bar::$staticProp);
};
