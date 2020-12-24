<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class PhpVersionBlacklistSourceLocator implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var PhpStormStubsSourceStubber */
    private $phpStormStubsSourceStubber;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber)
    {
        $this->sourceLocator = $sourceLocator;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
    }
    public function locateIdentifier(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        if ($identifier->isClass()) {
            if ($this->phpStormStubsSourceStubber->isPresentClass($identifier->getName()) === \false) {
                return null;
            }
        }
        if ($identifier->isFunction()) {
            if ($this->phpStormStubsSourceStubber->isPresentFunction($identifier->getName()) === \false) {
                return null;
            }
        }
        return $this->sourceLocator->locateIdentifier($reflector, $identifier);
    }
    public function locateIdentifiersByType(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return $this->sourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
}
