<?php

namespace _PhpScoperabd03f0baf05\ClassPhpDocsNamespace;

use function PHPStan\Analyser\assertType;
/**
 * @method string string()
 * @method array arrayOfStrings()
 * @psalm-method array<string> arrayOfStrings()
 * @phpstan-method array<string, int> arrayOfInts()
 * @method array arrayOfInts()
 * @method mixed overrodeMethod()
 * @method static mixed overrodeStaticMethod()
 */
class Foo
{
    public function __call($name, $arguments)
    {
    }
    public static function __callStatic($name, $arguments)
    {
    }
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('string', $this->string());
        \PHPStan\Analyser\assertType('array<string>', $this->arrayOfStrings());
        \PHPStan\Analyser\assertType('array<string, int>', $this->arrayOfInts());
        \PHPStan\Analyser\assertType('mixed', $this->overrodeMethod());
        \PHPStan\Analyser\assertType('mixed', static::overrodeStaticMethod());
    }
}
/**
 * @phpstan-method string overrodeMethod()
 * @phpstan-method static int overrodeStaticMethod()
 */
class Child extends \_PhpScoperabd03f0baf05\ClassPhpDocsNamespace\Foo
{
    public function doFoo()
    {
        \PHPStan\Analyser\assertType('string', $this->overrodeMethod());
        \PHPStan\Analyser\assertType('int', static::overrodeStaticMethod());
    }
}
