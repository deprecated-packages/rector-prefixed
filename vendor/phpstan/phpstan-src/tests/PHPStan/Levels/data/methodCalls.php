<?php

namespace _PhpScoper26e51eeacccf\Levels\MethodCalls;

class Foo
{
    public function doFoo(int $i)
    {
        $this->doFoo($i);
        $this->doFoo();
        $this->doFoo(1.1);
        $foo = new self();
        $foo->doFoo();
    }
}
class Bar
{
    public static function doBar(int $i)
    {
        \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar::doBar($i);
        \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar::doBar();
        \_PhpScoper26e51eeacccf\Levels\MethodCalls\Lorem::doBar();
        $bar = new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar();
        $bar::doBar($i);
        $bar::doBar();
    }
}
class Baz
{
    /**
     * @param Foo|Bar $fooOrBar
     * @param Foo|null $fooOrNull
     * @param Foo|Bar|null $fooOrBarOrNull
     * @param Bar|Baz $barOrBaz
     */
    public function doBaz($fooOrBar, ?\_PhpScoper26e51eeacccf\Levels\MethodCalls\Foo $fooOrNull, $fooOrBarOrNull, $barOrBaz)
    {
        $fooOrBar->doFoo(1);
        $fooOrBar->doFoo();
        $fooOrBar->doBaz();
        $fooOrNull->doFoo();
        $fooOrNull->doFoo(1);
        $fooOrBarOrNull->doFoo();
        $fooOrBarOrNull->doFoo(1);
        $barOrBaz->doFoo();
    }
}
class ClassWithMagicMethod
{
    public function doFoo()
    {
        $this->test();
    }
    /**
     * @param string $name
     * @param mixed[] $args
     */
    public function __call(string $name, array $args)
    {
    }
}
class AnotherClassWithMagicMethod
{
    public function doFoo()
    {
        self::test();
    }
    /**
     * @param string $name
     * @param mixed[] $args
     */
    public static function __callStatic(string $name, array $args)
    {
    }
}
class Ipsum
{
    /**
     * @return Foo|Bar
     */
    private function makeFooOrBar()
    {
        if (\rand(0, 1) === 0) {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Foo();
        } else {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar();
        }
    }
    /**
     * @return Foo|null
     */
    private function makeFooOrNull()
    {
        if (\rand(0, 1) === 0) {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Foo();
        } else {
            return null;
        }
    }
    /**
     * @return Foo|Bar|null
     */
    public function makeFooOrBarOrNull()
    {
        if (\rand(0, 1) === 0) {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Foo();
        } elseif (\rand(0, 1) === 1) {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar();
        } else {
            return null;
        }
    }
    /**
     * @return Bar|Baz
     */
    public function makeBarOrBaz()
    {
        if (\rand(0, 1) === 0) {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Bar();
        } else {
            return new \_PhpScoper26e51eeacccf\Levels\MethodCalls\Baz();
        }
    }
    public function doLorem()
    {
        $fooOrBar = $this->makeFooOrBar();
        $fooOrBar->doFoo(1);
        $fooOrBar->doFoo();
        $fooOrBar->doBaz();
        $fooOrNull = $this->makeFooOrNull();
        $fooOrNull->doFoo();
        $fooOrNull->doFoo(1);
        $fooOrBarOrNull = $this->makeFooOrBarOrNull();
        $fooOrBarOrNull->doFoo();
        $fooOrBarOrNull->doFoo(1);
        $barOrBaz = $this->makeBarOrBaz();
        $barOrBaz->doFoo();
    }
}
class FooException extends \Exception
{
    public function commonMethod()
    {
    }
    public function doFoo()
    {
    }
}
class BarException extends \Exception
{
    public function commonMethod()
    {
    }
    public function doBar()
    {
    }
}
class TestExceptions
{
    public function doFoo()
    {
        try {
        } catch (\_PhpScoper26e51eeacccf\Levels\MethodCalls\FooException|\_PhpScoper26e51eeacccf\Levels\MethodCalls\BarException $e) {
            $e->commonMethod();
            $e->doFoo();
            $e->doBar();
            $e->doBaz();
        }
    }
}
class ExtraArguments
{
    public function doFoo(int $i)
    {
        $this->doFoo();
        $this->doFoo(1);
        $this->doFoo(1, 2);
    }
}
