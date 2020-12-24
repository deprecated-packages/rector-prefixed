<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use function array_map;
use function array_merge;
class AggregateSourceLocator implements \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator[] */
    private $sourceLocators;
    /**
     * @param SourceLocator[] $sourceLocators
     */
    public function __construct(array $sourceLocators = [])
    {
        // This slightly confusing code simply type-checks the $sourceLocators
        // array by unpacking them and splatting them in the closure.
        $validator = static function (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator ...$sourceLocator) : array {
            return $sourceLocator;
        };
        $this->sourceLocators = $validator(...$sourceLocators);
    }
    public function locateIdentifier(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        foreach ($this->sourceLocators as $sourceLocator) {
            $located = $sourceLocator->locateIdentifier($reflector, $identifier);
            if ($located) {
                return $located;
            }
        }
        return null;
    }
    /**
     * {@inheritDoc}
     */
    public function locateIdentifiersByType(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_merge([], ...\array_map(static function (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator) use($reflector, $identifierType) {
            return $sourceLocator->locateIdentifiersByType($reflector, $identifierType);
        }, $this->sourceLocators));
    }
}
