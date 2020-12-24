<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

class MissingPropertyFromReflectionException extends \Exception
{
    public function __construct(string $className, string $propertyName)
    {
        parent::__construct(\sprintf('Property $%s was not found in reflection of class %s.', $propertyName, $className));
    }
}
