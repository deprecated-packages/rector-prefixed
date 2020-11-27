<?php

namespace _PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\FooInterface
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
class Bar extends \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Foo
{
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Bar
{
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Baz();
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
class Ipsum extends \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
    }
}
function (\_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Ipsum $ipsum, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class Dolor extends \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
    }
}
function (\_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\Dolor $ipsum, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\D $d) : void {
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
function (\_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\TestArrayObject2 $arrayObject2) : void {
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
function (\_PhpScoperbd5d0c5f7638\MethodWithPhpDocsImplicitInheritance\TestArrayObject3 $arrayObject3) : void {
    $arrayObject3->append(new \Exception());
};
