<?php

namespace _PhpScoperabd03f0baf05;

// lint < 8.0
class FooAccessStaticProperties
{
    public static $test;
    protected static $foo;
    public $loremIpsum;
}
// lint < 8.0
\class_alias('_PhpScoperabd03f0baf05\\FooAccessStaticProperties', 'FooAccessStaticProperties', \false);
class BarAccessStaticProperties extends \_PhpScoperabd03f0baf05\FooAccessStaticProperties
{
    public static function test()
    {
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$test;
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$foo;
        parent::$test;
        parent::$foo;
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$bar;
        // nonexistent
        self::$bar;
        // nonexistent
        parent::$bar;
        // nonexistent
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$loremIpsum;
        // instance
        static::$foo;
    }
    public function loremIpsum()
    {
        parent::$loremIpsum;
    }
}
\class_alias('_PhpScoperabd03f0baf05\\BarAccessStaticProperties', 'BarAccessStaticProperties', \false);
class IpsumAccessStaticProperties
{
    public static function ipsum()
    {
        parent::$lorem;
        // does not have a parent
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$test;
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$foo;
        // protected and not from a parent
        \_PhpScoperabd03f0baf05\FooAccessStaticProperties::${$foo};
        $class::$property;
        \_PhpScoperabd03f0baf05\UnknownStaticProperties::$test;
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
\class_alias('_PhpScoperabd03f0baf05\\IpsumAccessStaticProperties', 'IpsumAccessStaticProperties', \false);
function () {
    self::$staticFooProperty;
    static::$staticFooProperty;
    parent::$staticFooProperty;
    \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$test;
    \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$foo;
    \_PhpScoperabd03f0baf05\FooAccessStaticProperties::$loremIpsum;
    $foo = new \_PhpScoperabd03f0baf05\FooAccessStaticProperties();
    $foo::$test;
    $foo::$nonexistent;
    $bar = new \_PhpScoperabd03f0baf05\NonexistentClass();
    $bar::$test;
};
interface SomeInterface
{
}
\class_alias('_PhpScoperabd03f0baf05\\SomeInterface', 'SomeInterface', \false);
function (\_PhpScoperabd03f0baf05\FooAccessStaticProperties $foo) {
    if ($foo instanceof \_PhpScoperabd03f0baf05\SomeInterface) {
        $foo::$test;
        $foo::$nonexistent;
    }
    /** @var string|int $stringOrInt */
    $stringOrInt = \_PhpScoperabd03f0baf05\doFoo();
    $stringOrInt::$foo;
};
function (\_PhpScoperabd03f0baf05\FOOAccessStaticPropertieS $foo) {
    $foo::$test;
    // do not report case mismatch
    \_PhpScoperabd03f0baf05\FOOAccessStaticPropertieS::$unknownProperties;
    \_PhpScoperabd03f0baf05\FOOAccessStaticPropertieS::$loremIpsum;
    \_PhpScoperabd03f0baf05\FOOAccessStaticPropertieS::$foo;
    \_PhpScoperabd03f0baf05\FOOAccessStaticPropertieS::$test;
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
        $class = \_PhpScoperabd03f0baf05\doFoo();
        $class::$accessedProperty;
        $class::$unknownProperty;
        \_PhpScoperabd03f0baf05\Self::$accessedProperty;
    }
    public function doBar()
    {
        /** @var self|false $class */
        $class = \_PhpScoperabd03f0baf05\doFoo();
        if (isset($class::$anotherProperty)) {
            echo $class::$anotherProperty;
            echo $class::$instanceProperty;
        }
    }
}
\class_alias('_PhpScoperabd03f0baf05\\ClassOrString', 'ClassOrString', \false);
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
\class_alias('_PhpScoperabd03f0baf05\\AccessPropertyWithDimFetch', 'AccessPropertyWithDimFetch', \false);
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
\class_alias('_PhpScoperabd03f0baf05\\AccessInIsset', 'AccessInIsset', \false);
trait TraitWithStaticProperty
{
    public static $foo;
}
class MethodAccessingTraitProperty
{
    public function doFoo() : void
    {
        echo \_PhpScoperabd03f0baf05\TraitWithStaticProperty::$foo;
    }
    public function doBar(\_PhpScoperabd03f0baf05\TraitWithStaticProperty $a) : void
    {
        echo $a::$foo;
    }
}
\class_alias('_PhpScoperabd03f0baf05\\MethodAccessingTraitProperty', 'MethodAccessingTraitProperty', \false);
