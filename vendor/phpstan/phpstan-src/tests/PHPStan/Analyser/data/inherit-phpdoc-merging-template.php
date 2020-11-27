<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\InheritDocMergingTemplate;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @template T
     * @template U
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Foo
{
    public function doFoo($a, $b)
    {
        \PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $a);
        \PHPStan\Analyser\assertType('U (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $b);
    }
    public function doBar()
    {
        \PHPStan\Analyser\assertType('array<string>|int', $this->doFoo(1, 'hahaha'));
    }
}
class Dolor extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Foo
{
    /**
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingTemplate\\T', $a);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingTemplate\\U', $b);
    }
    public function doBar()
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\array<InheritDocMergingTemplate\\U>|InheritDocMergingTemplate\\T', $this->doFoo(1, 'hahaha'));
    }
}
class Sit extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Foo
{
    /**
     * @template T
     * @param T $a
     * @param U $b
     * @return T|array<U>
     */
    public function doFoo($a, $b)
    {
        \PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Sit::doFoo(), argument)', $a);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingTemplate\\U', $b);
    }
    public function doBar()
    {
        \PHPStan\Analyser\assertType('array<InheritDocMergingTemplate\\U>|int', $this->doFoo(1, 'hahaha'));
    }
}
class Amet extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Foo
{
    /** SomeComment */
    public function doFoo($a, $b)
    {
        \PHPStan\Analyser\assertType('T (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $a);
        \PHPStan\Analyser\assertType('U (method InheritDocMergingTemplate\\Foo::doFoo(), argument)', $b);
    }
    public function doBar()
    {
        \PHPStan\Analyser\assertType('array<string>|int', $this->doFoo(1, 'hahaha'));
    }
}
/**
 * @template T of object
 */
class Baz
{
    /**
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Baz
{
    public function doFoo($a)
    {
        \PHPStan\Analyser\assertType('object', $a);
    }
}
/**
 * @extends Baz<\stdClass>
 */
class Ipsum extends \_PhpScoper006a73f0e455\InheritDocMergingTemplate\Baz
{
    public function doFoo($a)
    {
        \PHPStan\Analyser\assertType('stdClass', $a);
    }
}
