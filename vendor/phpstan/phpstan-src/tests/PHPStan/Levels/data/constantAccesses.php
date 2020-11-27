<?php

namespace _PhpScoper006a73f0e455\Levels\ConstantAccesses;

function () {
    echo UNKNOWN_CONSTANT;
};
class Foo
{
    public const FOO_CONSTANT = 'foo';
    public function doFoo()
    {
        echo \_PhpScoper006a73f0e455\Levels\ConstantAccesses\Foo::FOO_CONSTANT;
        echo \_PhpScoper006a73f0e455\Levels\ConstantAccesses\Foo::BAR_CONSTANT;
        echo \_PhpScoper006a73f0e455\Levels\ConstantAccesses\Bar::FOO_CONSTANT;
        echo $this::BAR_CONSTANT;
        $foo = new self();
        echo $foo::BAR_CONSTANT;
    }
}
class Bar
{
}
class Baz
{
    /**
     * @param Foo|Bar $fooOrBar
     * @param Foo|null $fooOrNull
     * @param Foo|Bar|null $fooOrBarOrNull
     * @param Bar|Baz $barOrBaz
     */
    public function doBaz($fooOrBar, ?\_PhpScoper006a73f0e455\Levels\ConstantAccesses\Foo $fooOrNull, $fooOrBarOrNull, $barOrBaz)
    {
        echo $fooOrBar::FOO_CONSTANT;
        echo $fooOrBar::BAR_CONSTANT;
        echo $fooOrNull::FOO_CONSTANT;
        echo $fooOrNull::BAR_CONSTANT;
        echo $fooOrBarOrNull::FOO_CONSTANT;
        echo $fooOrBarOrNull::BAR_CONSTANT;
        echo $barOrBaz::FOO_CONSTANT;
    }
}
