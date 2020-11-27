<?php

namespace _PhpScoper88fe6e0ad041\ImpossibleInstanceOf;

interface Foo
{
}
interface Bar
{
}
interface BarChild extends \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar
{
}
class Lorem
{
}
class Ipsum extends \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem
{
}
class Dolor
{
}
class FooImpl implements \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo
{
}
class Test
{
    public function doTest(\_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo $foo, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar $bar, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem $lorem, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Ipsum $ipsum, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Dolor $dolor, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\FooImpl $fooImpl, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\BarChild $barChild)
    {
        if ($foo instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar) {
        }
        if ($bar instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        if ($lorem instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
        }
        if ($lorem instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Ipsum) {
        }
        if ($ipsum instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
        }
        if ($ipsum instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Ipsum) {
        }
        if ($dolor instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
        }
        if ($fooImpl instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        if ($barChild instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar) {
        }
        /** @var Collection|mixed[] $collection */
        $collection = doFoo();
        if ($collection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        /** @var object $object */
        $object = doFoo();
        if ($object instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        $str = 'str';
        if ($str instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        if ($str instanceof $str) {
        }
        if ($foo instanceof $str) {
        }
        $self = new self();
        if ($self instanceof self) {
        }
    }
    public function foreachWithTypeChange()
    {
        $foo = null;
        foreach ([] as $val) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
    public function whileWithTypeChange()
    {
        $foo = null;
        while (fetch()) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
    public function forWithTypeChange()
    {
        $foo = null;
        for (;;) {
            if ($foo instanceof self) {
            }
            if ($foo instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
            }
            $foo = new self();
            if ($foo instanceof self) {
            }
        }
    }
}
interface Collection extends \IteratorAggregate
{
}
final class FinalClassWithInvoke
{
    public function __invoke()
    {
    }
}
final class FinalClassWithoutInvoke
{
}
class ClassWithInvoke
{
    public function __invoke()
    {
    }
    public function doFoo(callable $callable, \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo $foo)
    {
        if ($callable instanceof self) {
        }
        if ($callable instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\FinalClassWithInvoke) {
        }
        if ($callable instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\FinalClassWithoutInvoke) {
        }
        if ($callable instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        if ($callable instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
        }
    }
}
class EliminateCompoundTypes
{
    /**
     * @param Lorem|Dolor $union
     * @param Foo&Bar $intersection
     */
    public function doFoo($union, $intersection)
    {
        if ($union instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem || $union instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Dolor) {
        } elseif ($union instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Lorem) {
        }
        if ($intersection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo && $intersection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar) {
        } elseif ($intersection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
        if ($intersection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        } elseif ($intersection instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar) {
        }
    }
}
class InstanceOfString
{
    /**
     * @param Foo|Bar|null $fooBarNull
     */
    public function doFoo($fooBarNull)
    {
        $string = 'Foo';
        if (\rand(0, 1) === 1) {
            $string = 'Bar';
        }
        if ($fooBarNull instanceof $string) {
            return;
        }
    }
}
trait TraitWithInstanceOfThis
{
    public function doFoo()
    {
        if ($this instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
        }
    }
}
class ClassUsingTrait implements \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo
{
    use TraitWithInstanceOfThis;
}
function (\Iterator $arg) {
    foreach ($arg as $key => $value) {
        \assert($key instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo);
    }
};
class ObjectSubtracted
{
    /**
     * @param object $object
     */
    public function doBar($object)
    {
        if ($object instanceof \Exception) {
            return;
        }
        if ($object instanceof \Exception) {
        }
        if ($object instanceof \InvalidArgumentException) {
        }
    }
    public function doBaz(\_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Bar $bar)
    {
        if ($bar instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\BarChild) {
            return;
        }
        if ($bar instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\BarChild) {
        }
        if ($bar instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\BarGrandChild) {
        }
    }
}
class BarGrandChild implements \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\BarChild
{
}
class InvalidTypeTest
{
    /**
     * @template ObjectT of InvalidTypeTest
     * @template MixedT
     *
     * @param mixed $subject
     * @param int $int
     * @param object $objectWithoutClass
     * @param InvalidTypeTest $object
     * @param int|InvalidTypeTest $intOrObject
     * @param string $string
     * @param mixed $mixed
     * @param mixed $mixed
     * @param ObjectT $objectT
     * @param MixedT $mixedT
     */
    public function doTest($int, $objectWithoutClass, $object, $intOrObject, $string, $mixed, $objectT, $mixedT)
    {
        if ($mixed instanceof $int) {
        }
        if ($mixed instanceof $objectWithoutClass) {
        }
        if ($mixed instanceof $object) {
        }
        if ($mixed instanceof $intOrObject) {
        }
        if ($mixed instanceof $string) {
        }
        if ($mixed instanceof $mixed) {
        }
        if ($mixed instanceof $objectT) {
        }
        if ($mixed instanceof $mixedT) {
        }
    }
}
class CheckInstanceofInIterableForeach
{
    /**
     * @param iterable<Foo> $items
     */
    public function test(iterable $items) : void
    {
        foreach ($items as $item) {
            if (!$item instanceof \_PhpScoper88fe6e0ad041\ImpossibleInstanceOf\Foo) {
                throw new \Exception('Unsupported');
            }
        }
    }
}
class CheckInstanceofWithTemplates
{
    /**
     * @template T of \Exception
     * @param T $e
     */
    public function test(\Throwable $t, $e) : void
    {
        if ($t instanceof $e) {
            return;
        }
        if ($e instanceof $t) {
            return;
        }
    }
}
class CheckGenericClassString
{
    /**
     * @param \DateTimeInterface $a
     * @param class-string<\DateTimeInterface> $b
     * @param class-string<\DateTimeInterface> $c
     */
    function test($a, $b, $c) : void
    {
        if ($a instanceof $b) {
            return;
        }
        if ($b instanceof $a) {
            return;
        }
        if ($b instanceof $c) {
            return;
        }
    }
}
class CheckGenericClassStringWithConstantString
{
    /**
     * @param class-string<\DateTimeInterface> $a
     * @param \DateTimeInterface $b
     */
    function test($a, $b) : void
    {
        $t = \DateTimeInterface::class;
        if ($a instanceof $t) {
            return;
        }
        if ($b instanceof $t) {
            return;
        }
    }
}
class CheckInstanceOfLsp
{
    function test(\DateTimeInterface $a, \DateTimeInterface $b) : void
    {
        if ($a instanceof $b) {
            return;
        }
        if ($b instanceof $a) {
            return;
        }
    }
}