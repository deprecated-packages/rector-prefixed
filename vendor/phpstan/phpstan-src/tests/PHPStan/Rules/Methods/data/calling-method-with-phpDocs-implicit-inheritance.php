<?php

namespace _PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    public function doBar($str)
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Foo
{
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Bar
{
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
class Lorem
{
    /**
     * @param B $b
     * @param C $c
     * @param A $a
     * @param D $d
     */
    public function doLorem($a, $b, $c, $d)
    {
    }
}
class Ipsum extends \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
    }
}
function (\_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Ipsum $ipsum, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class Dolor extends \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
    }
}
function (\_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\Dolor $ipsum, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class TestArrayObject
{
    /**
     * @param \ArrayObject<int, \stdClass> $arrayObject
     */
    public function doFoo(\ArrayObject $arrayObject) : void
    {
        $arrayObject->append(new \Exception());
    }
}
/**
 * @extends \ArrayObject<int, \stdClass>
 */
class TestArrayObject2 extends \ArrayObject
{
}
function (\_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\TestArrayObject2 $arrayObject2) : void {
    $arrayObject2->append(new \Exception());
};
/**
 * @extends \ArrayObject<int, \stdClass>
 */
class TestArrayObject3 extends \ArrayObject
{
    public function append($someValue)
    {
        return parent::append($someValue);
    }
}
function (\_PhpScoper88fe6e0ad041\MethodWithPhpDocsImplicitInheritance\TestArrayObject3 $arrayObject3) : void {
    $arrayObject3->append(new \Exception());
};
