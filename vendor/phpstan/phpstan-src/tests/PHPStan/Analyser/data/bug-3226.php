<?php

namespace _PhpScoperbd5d0c5f7638\Bug3226;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @var class-string
     */
    private $class;
    /**
     * @param class-string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }
    /**
     * @return class-string
     */
    public function __toString() : string
    {
        return $this->class;
    }
}
function (\_PhpScoperbd5d0c5f7638\Bug3226\Foo $foo) : void {
    \PHPStan\Analyser\assertType('class-string', $foo->__toString());
    \PHPStan\Analyser\assertType('class-string', (string) $foo);
};
/**
 * @template T
 */
class Bar
{
    /**
     * @var class-string<T>
     */
    private $class;
    /**
     * @param class-string<T> $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }
    /**
     * @return class-string<T>
     */
    public function __toString() : string
    {
        return $this->class;
    }
}
function (\_PhpScoperbd5d0c5f7638\Bug3226\Bar $bar) : void {
    \PHPStan\Analyser\assertType('class-string<mixed>', $bar->__toString());
    \PHPStan\Analyser\assertType('class-string<mixed>', (string) $bar);
};
function () : void {
    $bar = new \_PhpScoperbd5d0c5f7638\Bug3226\Bar(\Exception::class);
    \PHPStan\Analyser\assertType('class-string<Exception>', $bar->__toString());
    \PHPStan\Analyser\assertType('class-string<Exception>', (string) $bar);
};
