<?php

namespace _PhpScoper88fe6e0ad041\Bug1216PropertyTest;

abstract class Foo
{
    /**
     * @var int
     */
    protected $foo;
}
trait Bar
{
    /**
     * @var int
     */
    protected $bar;
    protected $untypedBar;
}
/**
 * @property string $foo
 * @property string $bar
 * @property string $untypedBar
 */
class Baz extends \_PhpScoper88fe6e0ad041\Bug1216PropertyTest\Foo
{
    public function __construct()
    {
        $this->foo = 'foo';
        // OK
        $this->bar = 'bar';
        // OK
        $this->untypedBar = 123;
        // error
    }
}
trait DecoratorTrait
{
    /** @var \stdClass */
    public $foo;
}
/**
 * @property \Exception $foo
 */
class Dummy
{
    use DecoratorTrait;
}
function (\_PhpScoper88fe6e0ad041\Bug1216PropertyTest\Dummy $dummy) : void {
    $dummy->foo = new \stdClass();
};
function (\_PhpScoper88fe6e0ad041\Bug1216PropertyTest\Dummy $dummy) : void {
    $dummy->foo = new \Exception();
};
