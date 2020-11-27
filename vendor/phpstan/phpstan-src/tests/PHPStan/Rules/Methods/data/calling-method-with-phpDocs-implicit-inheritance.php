<?php

namespace _PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\FooInterface
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
class Bar extends \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Foo
{
    public function doFoo($i)
    {
    }
}
class Baz extends \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Bar
{
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Baz();
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
class Ipsum extends \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Lorem
{
    public function doLorem($x, $y, $z, $d)
    {
    }
}
function (\_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Ipsum $ipsum, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\D $d) : void {
    $ipsum->doLorem($a, $b, $c, $d);
    $ipsum->doLorem(1, 1, 1, 1);
};
class Dolor extends \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Ipsum
{
    public function doLorem($g, $h, $i, $d)
    {
    }
}
function (\_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\Dolor $ipsum, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\A $a, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\B $b, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\C $c, \_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\D $d) : void {
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
function (\_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\TestArrayObject2 $arrayObject2) : void {
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
function (\_PhpScoper006a73f0e455\MethodWithPhpDocsImplicitInheritance\TestArrayObject3 $arrayObject3) : void {
    $arrayObject3->append(new \Exception());
};
