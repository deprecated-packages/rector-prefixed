<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection;

class ParameterNotFoundException extends \Exception
{
    public function __construct(string $parameterName)
    {
        parent::__construct(\sprintf('Parameter %s not found in the container.', $parameterName));
    }
}
