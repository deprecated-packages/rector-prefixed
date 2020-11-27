<?php

namespace _PhpScoperbd5d0c5f7638\CallStaticMethods;

class Foo
{
    public static function test()
    {
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Bar::protectedMethodFromChild();
    }
    protected static function baz()
    {
    }
    public function loremIpsum()
    {
    }
    private static function dolor()
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo
{
    public static function test()
    {
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::test();
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::baz();
        parent::test();
        parent::baz();
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::bar();
        // nonexistent
        self::bar();
        // nonexistent
        parent::bar();
        // nonexistent
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::loremIpsum();
        // instance
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::dolor();
    }
    public function loremIpsum()
    {
        parent::loremIpsum();
    }
    protected static function protectedMethodFromChild()
    {
    }
}
class Ipsum
{
    public static function ipsumTest()
    {
        parent::lorem();
        // does not have a parent
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::test();
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::test(1);
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::baz();
        // protected and not from a parent
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\UnknownStaticMethodClass::loremIpsum();
    }
}
class ClassWithConstructor
{
    private function __construct($foo)
    {
    }
}
class CheckConstructor extends \_PhpScoperbd5d0c5f7638\CallStaticMethods\ClassWithConstructor
{
    public function __construct()
    {
        parent::__construct();
    }
}
function () {
    self::someStaticMethod();
    static::someStaticMethod();
    parent::someStaticMethod();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::test();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::baz();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::bar();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::loremIpsum();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo::dolor();
    \Locale::getDisplayLanguage('cs_CZ');
    // OK
    \Locale::getDisplayLanguage('cs_CZ', 'en');
    // OK
    \Locale::getDisplayLanguage('cs_CZ', 'en', 'foo');
    // should report 3 parameters given, 1-2 required
};
interface SomeInterface
{
}
function (\_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo $foo) {
    if ($foo instanceof \_PhpScoperbd5d0c5f7638\CallStaticMethods\SomeInterface) {
        $foo::test();
        $foo::test(1, 2, 3);
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = doFoo();
    $stringOrInt::foo();
};
function (\_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO $foo) {
    $foo::test();
    // do not report case mismatch
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::unknownMethod();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::loremIpsum();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::dolor();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::test(1, 2, 3);
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::TEST();
    \_PhpScoperbd5d0c5f7638\CallStaticMethods\FOO::test();
};
function (string $className) {
    $className::foo();
};
class CallingNonexistentParentConstructor extends \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo
{
    public function __construct()
    {
        parent::__construct();
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\CallStaticMethods\Foo
{
    public function doFoo()
    {
        parent::nonexistent();
    }
    public static function doBaz()
    {
        parent::nonexistent();
        parent::loremIpsum();
    }
}
class ClassOrString
{
    public function doFoo()
    {
        /** @var self|string $class */
        $class = doFoo();
        $class::calledMethod();
        $class::calledMethod(1);
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\Self::calledMethod();
    }
    private static function calledMethod()
    {
    }
    public function doBar()
    {
        if (\rand(0, 1)) {
            $class = 'Blabla';
        } else {
            $class = 'Bleble';
        }
        $class::calledMethod();
    }
}
interface InterfaceWithStaticMethod
{
    public static function doFoo();
    public function doInstanceFoo();
}
class CallStaticMethodOnAnInterface
{
    public function doFoo(\_PhpScoperbd5d0c5f7638\CallStaticMethods\InterfaceWithStaticMethod $foo)
    {
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\InterfaceWithStaticMethod::doFoo();
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\InterfaceWithStaticMethod::doBar();
        $foo::doFoo();
        // fine - it's an object
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\InterfaceWithStaticMethod::doInstanceFoo();
        $foo::doInstanceFoo();
    }
}
class CallStaticMethodAfterAssignmentInBooleanAnd
{
    public static function generateDeliverSmDlrForMessage()
    {
        if (($messageState = self::getMessageStateByStatusId()) && self::isMessageStateRequested($messageState)) {
        }
    }
    /**
     * @return false|string
     */
    public static function getMessageStateByStatusId()
    {
    }
    public static function isMessageStateRequested(string $messageState) : bool
    {
    }
}
class PreserveArrayKeys
{
    private $p = [];
    /**
     * @param array<string, bool> $map
     */
    private function test(array $map)
    {
        foreach ($this->p['foo'] as $key => $_) {
            if (!isset($map[$key])) {
                throw self::e(\array_keys($map));
            }
        }
    }
    /**
     * @param array<string, bool> $map
     */
    private function test2(array $map)
    {
        foreach ($this->p['foo'] as $key => $_) {
            if (!\array_key_exists($key, $map)) {
                throw self::e(\array_keys($map));
            }
        }
    }
    /**
     * @param string[] $list
     */
    private static function e($list) : \Exception
    {
        return new \Exception();
    }
}
class ClassStringChecks
{
    /**
     * @template T of Foo
     * @param class-string $classString
     * @param class-string<T> $anotherClassString
     * @param class-string<Foo> $yetAnotherClassString
     */
    public function doFoo(string $classString, string $anotherClassString, string $yetAnotherClassString)
    {
        $classString::nonexistentMethod();
        $anotherClassString::test();
        $anotherClassString::test(1, 2, 3);
        $anotherClassString::nonexistentMethod();
        $yetAnotherClassString::test();
        $yetAnotherClassString::test(1, 2, 3);
        $yetAnotherClassString::nonexistentMethod();
    }
}
trait TraitWithStaticMethod
{
    public static function doFoo() : void
    {
    }
}
class MethodCallingTraitWithStaticMethod
{
    public function doFoo() : void
    {
        \_PhpScoperbd5d0c5f7638\CallStaticMethods\TraitWithStaticMethod::doFoo();
    }
    public function doBar(\_PhpScoperbd5d0c5f7638\CallStaticMethods\TraitWithStaticMethod $a) : void
    {
        $a::doFoo();
    }
}
