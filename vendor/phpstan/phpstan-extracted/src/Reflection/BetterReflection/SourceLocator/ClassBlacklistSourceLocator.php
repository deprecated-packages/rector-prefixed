<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\Identifier;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\IdentifierType;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflection\Reflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class ClassBlacklistSourceLocator implements \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var string[] */
    private $patterns;
    /**
     * @param SourceLocator $sourceLocator
     * @param string[] $patterns
     */
    public function __construct(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, array $patterns)
    {
        $this->sourceLocator = $sourceLocator;
        $this->patterns = $patterns;
    }
    public function locateIdentifier(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflection\Reflection
    {
        if ($identifier->isClass()) {
            foreach ($this->patterns as $pattern) {
                if (\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings::match($identifier->getName(), $pattern) !== null) {
                    return null;
                }
            }
        }
        return $this->sourceLocator->locateIdentifier($reflector, $identifier);
    }
    public function locateIdentifiersByType(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return $this->sourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
}
