<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class ClassBlacklistSourceLocator implements \_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /**
     * @var \Roave\BetterReflection\SourceLocator\Type\SourceLocator
     */
    private $sourceLocator;
    /** @var string[] */
    private $patterns;
    /**
     * @param SourceLocator $sourceLocator
     * @param string[] $patterns
     */
    public function __construct(\_PhpScoper006a73f0e455\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, array $patterns)
    {
        $this->sourceLocator = $sourceLocator;
        $this->patterns = $patterns;
    }
    public function locateIdentifier(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\Reflection
    {
        if ($identifier->isClass()) {
            foreach ($this->patterns as $pattern) {
                if (\_PhpScoper006a73f0e455\Nette\Utils\Strings::match($identifier->getName(), $pattern) !== null) {
                    return null;
                }
            }
        }
        return $this->sourceLocator->locateIdentifier($reflector, $identifier);
    }
    public function locateIdentifiersByType(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return $this->sourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
}
