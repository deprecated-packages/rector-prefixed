<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class PhpVersionBlacklistSourceLocator implements \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var PhpStormStubsSourceStubber */
    private $phpStormStubsSourceStubber;
    public function __construct(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber)
    {
        $this->sourceLocator = $sourceLocator;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
    }
    public function locateIdentifier(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
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
    public function locateIdentifiersByType(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return $this->sourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
}
