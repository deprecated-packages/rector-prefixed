<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Analyser\Bug3142;

use function PHPStan\Analyser\assertType;
class ParentClass
{
    /**
     * @return int
     */
    public function sayHi()
    {
        return 'hi';
    }
}
/**
 * @method string sayHi()
 * @method string sayHello()
 */
class HelloWorld extends \_PhpScopera143bcca66cb\Analyser\Bug3142\ParentClass
{
    /**
     * @return int
     */
    public function sayHello()
    {
        return 'hello';
    }
}
function () : void {
    $hw = new \_PhpScopera143bcca66cb\Analyser\Bug3142\HelloWorld();
    \PHPStan\Analyser\assertType('string', $hw->sayHi());
    \PHPStan\Analyser\assertType('int', $hw->sayHello());
};
interface DecoratorInterface
{
}
class FooDecorator implements \_PhpScopera143bcca66cb\Analyser\Bug3142\DecoratorInterface
{
    public function getCode() : string
    {
        return 'FOO';
    }
}
trait DecoratorTrait
{
    public function getDecorator() : \_PhpScopera143bcca66cb\Analyser\Bug3142\DecoratorInterface
    {
        return new \_PhpScopera143bcca66cb\Analyser\Bug3142\FooDecorator();
    }
}
/**
 * @method FooDecorator getDecorator()
 */
class Dummy
{
    use DecoratorTrait;
    public function getLabel() : string
    {
        return $this->getDecorator()->getCode();
    }
}
function () {
    $dummy = new \_PhpScopera143bcca66cb\Analyser\Bug3142\Dummy();
    \PHPStan\Analyser\assertType(\_PhpScopera143bcca66cb\Analyser\Bug3142\FooDecorator::class, $dummy->getDecorator());
};
