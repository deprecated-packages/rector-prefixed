<?php

namespace _PhpScoper26e51eeacccf;

// lint < 8.0
class FooAccessStaticProperties
{
    public static $test;
    protected static $foo;
    public $loremIpsum;
}
// lint < 8.0
\class_alias('_PhpScoper26e51eeacccf\\FooAccessStaticProperties', 'FooAccessStaticProperties', \false);
class BarAccessStaticProperties extends \_PhpScoper26e51eeacccf\FooAccessStaticProperties
{
    public static function test()
    {
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$test;
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$foo;
        parent::$test;
        parent::$foo;
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$bar;
        // nonexistent
        self::$bar;
        // nonexistent
        parent::$bar;
        // nonexistent
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$loremIpsum;
        // instance
        static::$foo;
    }
    public function loremIpsum()
    {
        parent::$loremIpsum;
    }
}
\class_alias('_PhpScoper26e51eeacccf\\BarAccessStaticProperties', 'BarAccessStaticProperties', \false);
class IpsumAccessStaticProperties
{
    public static function ipsum()
    {
        parent::$lorem;
        // does not have a parent
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$test;
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$foo;
        // protected and not from a parent
        \_PhpScoper26e51eeacccf\FooAccessStaticProperties::${$foo};
        $class::$property;
        \_PhpScoper26e51eeacccf\UnknownStaticProperties::$test;
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
\class_alias('_PhpScoper26e51eeacccf\\IpsumAccessStaticProperties', 'IpsumAccessStaticProperties', \false);
function () {
    self::$staticFooProperty;
    static::$staticFooProperty;
    parent::$staticFooProperty;
    \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$test;
    \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$foo;
    \_PhpScoper26e51eeacccf\FooAccessStaticProperties::$loremIpsum;
    $foo = new \_PhpScoper26e51eeacccf\FooAccessStaticProperties();
    $foo::$test;
    $foo::$nonexistent;
    $bar = new \_PhpScoper26e51eeacccf\NonexistentClass();
    $bar::$test;
};
interface SomeInterface
{
}
\class_alias('_PhpScoper26e51eeacccf\\SomeInterface', 'SomeInterface', \false);
function (\_PhpScoper26e51eeacccf\FooAccessStaticProperties $foo) {
    if ($foo instanceof \_PhpScoper26e51eeacccf\SomeInterface) {
        $foo::$test;
        $foo::$nonexistent;
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = \_PhpScoper26e51eeacccf\doFoo();
    $stringOrInt::$foo;
};
function (\_PhpScoper26e51eeacccf\FOOAccessStaticPropertieS $foo) {
    $foo::$test;
    // do not report case mismatch
    \_PhpScoper26e51eeacccf\FOOAccessStaticPropertieS::$unknownProperties;
    \_PhpScoper26e51eeacccf\FOOAccessStaticPropertieS::$loremIpsum;
    \_PhpScoper26e51eeacccf\FOOAccessStaticPropertieS::$foo;
    \_PhpScoper26e51eeacccf\FOOAccessStaticPropertieS::$test;
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
        $class = \_PhpScoper26e51eeacccf\doFoo();
        $class::$accessedProperty;
        $class::$unknownProperty;
        \_PhpScoper26e51eeacccf\Self::$accessedProperty;
    }
    public function doBar()
    {
        /** @var self|false $class */
        $class = \_PhpScoper26e51eeacccf\doFoo();
        if (isset($class::$anotherProperty)) {
            echo $class::$anotherProperty;
            echo $class::$instanceProperty;
        }
    }
}
\class_alias('_PhpScoper26e51eeacccf\\ClassOrString', 'ClassOrString', \false);
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
\class_alias('_PhpScoper26e51eeacccf\\AccessPropertyWithDimFetch', 'AccessPropertyWithDimFetch', \false);
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
\class_alias('_PhpScoper26e51eeacccf\\AccessInIsset', 'AccessInIsset', \false);
trait TraitWithStaticProperty
{
    public static $foo;
}
class MethodAccessingTraitProperty
{
    public function doFoo() : void
    {
        echo \_PhpScoper26e51eeacccf\TraitWithStaticProperty::$foo;
    }
    public function doBar(\_PhpScoper26e51eeacccf\TraitWithStaticProperty $a) : void
    {
        echo $a::$foo;
    }
}
\class_alias('_PhpScoper26e51eeacccf\\MethodAccessingTraitProperty', 'MethodAccessingTraitProperty', \false);
