<?php

namespace _PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\FooInterface
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
class Bar extends \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Foo
{
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Bar
{
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Baz();
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
class Ipsum extends \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
    }
}
function (\_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Ipsum $ipsum, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class Dolor extends \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
    }
}
function (\_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\Dolor $ipsum, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\D $d) : void {
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
function (\_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\TestArrayObject2 $arrayObject2) : void {
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
function (\_PhpScopera143bcca66cb\MethodWithPhpDocsImplicitInheritance\TestArrayObject3 $arrayObject3) : void {
    $arrayObject3->append(new \Exception());
};
