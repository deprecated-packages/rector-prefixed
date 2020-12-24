<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

class MissingMethodFromReflectionException extends \Exception
{
    public function __construct(string $className, string $methodName)
    {
        parent::__construct(\sprintf('Method %s() was not found in reflection of class %s.', $methodName, $className));
    }
}
