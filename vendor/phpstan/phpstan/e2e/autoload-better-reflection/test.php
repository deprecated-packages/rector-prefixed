<?php

namespace RectorPrefix20210504\TestBetterReflectionAutoload;

use PHPStan\BetterReflection\Identifier\Identifier;
use PHPStan\BetterReflection\Identifier\IdentifierType;
use PHPStan\BetterReflection\Reflection\Reflection;
use PHPStan\BetterReflection\Reflector\Reflector;
use PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
require_once __DIR__ . '/../../bootstrap.php';
class Foo implements \PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    public function locateIdentifier(\PHPStan\BetterReflection\Reflector\Reflector $reflector, \PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\PHPStan\BetterReflection\Reflection\Reflection
    {
        return null;
    }
    public function locateIdentifiersByType(\PHPStan\BetterReflection\Reflector\Reflector $reflector, \PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
    }
}
