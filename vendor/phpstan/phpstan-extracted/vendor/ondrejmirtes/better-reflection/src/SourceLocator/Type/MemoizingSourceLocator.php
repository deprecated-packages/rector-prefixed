<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use function array_key_exists;
use function get_class;
use function spl_object_hash;
final class MemoizingSourceLocator implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator */
    private $wrappedSourceLocator;
    /** @var Reflection[]|null[] indexed by reflector key and identifier cache key */
    private $cacheByIdentifierKeyAndOid = [];
    /** @var Reflection[][] indexed by reflector key and identifier type cache key */
    private $cacheByIdentifierTypeKeyAndOid = [];
    public function __construct(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $wrappedSourceLocator)
    {
        $this->wrappedSourceLocator = $wrappedSourceLocator;
    }
    public function locateIdentifier(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $cacheKey = $this->reflectorCacheKey($reflector) . '_' . $this->identifierToCacheKey($identifier);
        if (\array_key_exists($cacheKey, $this->cacheByIdentifierKeyAndOid)) {
            return $this->cacheByIdentifierKeyAndOid[$cacheKey];
        }
        return $this->cacheByIdentifierKeyAndOid[$cacheKey] = $this->wrappedSourceLocator->locateIdentifier($reflector, $identifier);
    }
    /**
     * @return Reflection[]
     */
    public function locateIdentifiersByType(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        $cacheKey = $this->reflectorCacheKey($reflector) . '_' . $this->identifierTypeToCacheKey($identifierType);
        if (\array_key_exists($cacheKey, $this->cacheByIdentifierTypeKeyAndOid)) {
            return $this->cacheByIdentifierTypeKeyAndOid[$cacheKey];
        }
        return $this->cacheByIdentifierTypeKeyAndOid[$cacheKey] = $this->wrappedSourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
    private function reflectorCacheKey(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector) : string
    {
        return 'type:' . \get_class($reflector) . '#oid:' . \spl_object_hash($reflector);
    }
    private function identifierToCacheKey(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : string
    {
        return $this->identifierTypeToCacheKey($identifier->getType()) . '#name:' . $identifier->getName();
    }
    private function identifierTypeToCacheKey(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : string
    {
        return 'type:' . $identifierType->getName();
    }
}
