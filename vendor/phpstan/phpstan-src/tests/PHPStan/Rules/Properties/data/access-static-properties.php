<?php

namespace _PhpScoperbd5d0c5f7638;

// lint < 8.0
class FooAccessStaticProperties
{
    public static $test;
    protected static $foo;
    public $loremIpsum;
}
// lint < 8.0
\class_alias('_PhpScoperbd5d0c5f7638\\FooAccessStaticProperties', 'FooAccessStaticProperties', \false);
class BarAccessStaticProperties extends \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties
{
    public static function test()
    {
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$test;
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$foo;
        parent::$test;
        parent::$foo;
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$bar;
        // nonexistent
        self::$bar;
        // nonexistent
        parent::$bar;
        // nonexistent
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$loremIpsum;
        // instance
        static::$foo;
    }
    public function loremIpsum()
    {
        parent::$loremIpsum;
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\BarAccessStaticProperties', 'BarAccessStaticProperties', \false);
class IpsumAccessStaticProperties
{
    public static function ipsum()
    {
        parent::$lorem;
        // does not have a parent
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$test;
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$foo;
        // protected and not from a parent
        \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::${$foo};
        $class::$property;
        \_PhpScoperbd5d0c5f7638\UnknownStaticProperties::$test;
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
\class_alias('_PhpScoperbd5d0c5f7638\\IpsumAccessStaticProperties', 'IpsumAccessStaticProperties', \false);
function () {
    self::$staticFooProperty;
    static::$staticFooProperty;
    parent::$staticFooProperty;
    \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$test;
    \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$foo;
    \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties::$loremIpsum;
    $foo = new \_PhpScoperbd5d0c5f7638\FooAccessStaticProperties();
    $foo::$test;
    $foo::$nonexistent;
    $bar = new \_PhpScoperbd5d0c5f7638\NonexistentClass();
    $bar::$test;
};
interface SomeInterface
{
}
\class_alias('_PhpScoperbd5d0c5f7638\\SomeInterface', 'SomeInterface', \false);
function (\_PhpScoperbd5d0c5f7638\FooAccessStaticProperties $foo) {
    if ($foo instanceof \_PhpScoperbd5d0c5f7638\SomeInterface) {
        $foo::$test;
        $foo::$nonexistent;
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = \_PhpScoperbd5d0c5f7638\doFoo();
    $stringOrInt::$foo;
};
function (\_PhpScoperbd5d0c5f7638\FOOAccessStaticPropertieS $foo) {
    $foo::$test;
    // do not report case mismatch
    \_PhpScoperbd5d0c5f7638\FOOAccessStaticPropertieS::$unknownProperties;
    \_PhpScoperbd5d0c5f7638\FOOAccessStaticPropertieS::$loremIpsum;
    \_PhpScoperbd5d0c5f7638\FOOAccessStaticPropertieS::$foo;
    \_PhpScoperbd5d0c5f7638\FOOAccessStaticPropertieS::$test;
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
        $class = \_PhpScoperbd5d0c5f7638\doFoo();
        $class::$accessedProperty;
        $class::$unknownProperty;
        \_PhpScoperbd5d0c5f7638\Self::$accessedProperty;
    }
    public function doBar()
    {
        /** @var self|false $class */
        $class = \_PhpScoperbd5d0c5f7638\doFoo();
        if (isset($class::$anotherProperty)) {
            echo $class::$anotherProperty;
            echo $class::$instanceProperty;
        }
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\ClassOrString', 'ClassOrString', \false);
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
\class_alias('_PhpScoperbd5d0c5f7638\\AccessPropertyWithDimFetch', 'AccessPropertyWithDimFetch', \false);
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
\class_alias('_PhpScoperbd5d0c5f7638\\AccessInIsset', 'AccessInIsset', \false);
trait TraitWithStaticProperty
{
    public static $foo;
}
class MethodAccessingTraitProperty
{
    public function doFoo() : void
    {
        echo \_PhpScoperbd5d0c5f7638\TraitWithStaticProperty::$foo;
    }
    public function doBar(\_PhpScoperbd5d0c5f7638\TraitWithStaticProperty $a) : void
    {
        echo $a::$foo;
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\MethodAccessingTraitProperty', 'MethodAccessingTraitProperty', \false);
