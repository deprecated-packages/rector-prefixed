<?php

namespace _PhpScopera143bcca66cb;

// lint < 8.0
class FooAccessStaticProperties
{
    public static $test;
    protected static $foo;
    public $loremIpsum;
}
// lint < 8.0
\class_alias('_PhpScopera143bcca66cb\\FooAccessStaticProperties', 'FooAccessStaticProperties', \false);
class BarAccessStaticProperties extends \_PhpScopera143bcca66cb\FooAccessStaticProperties
{
    public static function test()
    {
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$test;
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$foo;
        parent::$test;
        parent::$foo;
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$bar;
        // nonexistent
        self::$bar;
        // nonexistent
        parent::$bar;
        // nonexistent
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$loremIpsum;
        // instance
        static::$foo;
    }
    public function loremIpsum()
    {
        parent::$loremIpsum;
    }
}
\class_alias('_PhpScopera143bcca66cb\\BarAccessStaticProperties', 'BarAccessStaticProperties', \false);
class IpsumAccessStaticProperties
{
    public static function ipsum()
    {
        parent::$lorem;
        // does not have a parent
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$test;
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::$foo;
        // protected and not from a parent
        \_PhpScopera143bcca66cb\FooAccessStaticProperties::${$foo};
        $class::$property;
        \_PhpScopera143bcca66cb\UnknownStaticProperties::$test;
        if (isset(static::$baz)) {
            static::$baz;
        }
        isset(static::$baz);
        static::$baz;
        if (!isset(static::$nonexistent)) {
            static::$nonexistent;
            return;
        }
        static::$nonexistent;
        if (!empty(static::$emptyBaz)) {
            static::$emptyBaz;
        }
        static::$emptyBaz;
        if (empty(static::$emptyNonexistent)) {
            static::$emptyNonexistent;
            return;
        }
        static::$emptyNonexistent;
        isset(static::$anotherNonexistent) ? static::$anotherNonexistent : null;
        isset(static::$anotherNonexistent) ? null : static::$anotherNonexistent;
        !isset(static::$anotherNonexistent) ? static::$anotherNonexistent : null;
        !isset(static::$anotherNonexistent) ? null : static::$anotherNonexistent;
        empty(static::$anotherEmptyNonexistent) ? static::$anotherEmptyNonexistent : null;
        empty(static::$anotherEmptyNonexistent) ? null : static::$anotherEmptyNonexistent;
        !empty(static::$anotherEmptyNonexistent) ? static::$anotherEmptyNonexistent : null;
        !empty(static::$anotherEmptyNonexistent) ? null : static::$anotherEmptyNonexistent;
    }
}
\class_alias('_PhpScopera143bcca66cb\\IpsumAccessStaticProperties', 'IpsumAccessStaticProperties', \false);
function () {
    self::$staticFooProperty;
    static::$staticFooProperty;
    parent::$staticFooProperty;
    \_PhpScopera143bcca66cb\FooAccessStaticProperties::$test;
    \_PhpScopera143bcca66cb\FooAccessStaticProperties::$foo;
    \_PhpScopera143bcca66cb\FooAccessStaticProperties::$loremIpsum;
    $foo = new \_PhpScopera143bcca66cb\FooAccessStaticProperties();
    $foo::$test;
    $foo::$nonexistent;
    $bar = new \_PhpScopera143bcca66cb\NonexistentClass();
    $bar::$test;
};
interface SomeInterface
{
}
\class_alias('_PhpScopera143bcca66cb\\SomeInterface', 'SomeInterface', \false);
function (\_PhpScopera143bcca66cb\FooAccessStaticProperties $foo) {
    if ($foo instanceof \_PhpScopera143bcca66cb\SomeInterface) {
        $foo::$test;
        $foo::$nonexistent;
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = \_PhpScopera143bcca66cb\doFoo();
    $stringOrInt::$foo;
};
function (\_PhpScopera143bcca66cb\FOOAccessStaticPropertieS $foo) {
    $foo::$test;
    // do not report case mismatch
    \_PhpScopera143bcca66cb\FOOAccessStaticPropertieS::$unknownProperties;
    \_PhpScopera143bcca66cb\FOOAccessStaticPropertieS::$loremIpsum;
    \_PhpScopera143bcca66cb\FOOAccessStaticPropertieS::$foo;
    \_PhpScopera143bcca66cb\FOOAccessStaticPropertieS::$test;
};
function (string $className) {
    $className::$fooProperty;
};
class ClassOrString
{
    private static $accessedProperty;
    private $instanceProperty;
    public function doFoo()
    {
        /** @var self|string $class */
        $class = \_PhpScopera143bcca66cb\doFoo();
        $class::$accessedProperty;
        $class::$unknownProperty;
        \_PhpScopera143bcca66cb\Self::$accessedProperty;
    }
    public function doBar()
    {
        /** @var self|false $class */
        $class = \_PhpScopera143bcca66cb\doFoo();
        if (isset($class::$anotherProperty)) {
            echo $class::$anotherProperty;
            echo $class::$instanceProperty;
        }
    }
}
\class_alias('_PhpScopera143bcca66cb\\ClassOrString', 'ClassOrString', \false);
class AccessPropertyWithDimFetch
{
    public function doFoo()
    {
        self::$foo['foo'] = 'test';
    }
    public function doBar()
    {
        self::$foo = 'test';
        // reported by a separate rule
    }
}
\class_alias('_PhpScopera143bcca66cb\\AccessPropertyWithDimFetch', 'AccessPropertyWithDimFetch', \false);
class AccessInIsset
{
    public function doFoo()
    {
        if (isset(self::$foo)) {
        }
    }
    public function doBar()
    {
        if (isset(self::$foo['foo'])) {
        }
    }
}
\class_alias('_PhpScopera143bcca66cb\\AccessInIsset', 'AccessInIsset', \false);
trait TraitWithStaticProperty
{
    public static $foo;
}
class MethodAccessingTraitProperty
{
    public function doFoo() : void
    {
        echo \_PhpScopera143bcca66cb\TraitWithStaticProperty::$foo;
    }
    public function doBar(\_PhpScopera143bcca66cb\TraitWithStaticProperty $a) : void
    {
        echo $a::$foo;
    }
}
\class_alias('_PhpScopera143bcca66cb\\MethodAccessingTraitProperty', 'MethodAccessingTraitProperty', \false);
