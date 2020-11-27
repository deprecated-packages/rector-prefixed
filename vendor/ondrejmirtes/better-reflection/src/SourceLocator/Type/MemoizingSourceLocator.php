<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type;

use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector;
use function array_key_exists;
use function get_class;
use function spl_object_hash;
final class MemoizingSourceLocator implements \_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var SourceLocator */
    private $wrappedSourceLocator;
    /** @var Reflection[]|null[] indexed by reflector key and identifier cache key */
    private $cacheByIdentifierKeyAndOid = [];
    /** @var Reflection[][] indexed by reflector key and identifier type cache key */
    private $cacheByIdentifierTypeKeyAndOid = [];
    public function __construct(\_PhpScopera143bcca66cb\Roave\BetterReflection\SourceLocator\Type\SourceLocator $wrappedSourceLocator)
    {
        $this->wrappedSourceLocator = $wrappedSourceLocator;
    }
    public function locateIdentifier(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\Reflection
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
    public function locateIdentifiersByType(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        $cacheKey = $this->reflectorCacheKey($reflector) . '_' . $this->identifierTypeToCacheKey($identifierType);
        if (\array_key_exists($cacheKey, $this->cacheByIdentifierTypeKeyAndOid)) {
            return $this->cacheByIdentifierTypeKeyAndOid[$cacheKey];
        }
        return $this->cacheByIdentifierTypeKeyAndOid[$cacheKey] = $this->wrappedSourceLocator->locateIdentifiersByType($reflector, $identifierType);
    }
    private function reflectorCacheKey(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\Reflector $reflector) : string
    {
        return 'type:' . \get_class($reflector) . '#oid:' . \spl_object_hash($reflector);
    }
    private function identifierToCacheKey(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\Identifier $identifier) : string
    {
        return $this->identifierTypeToCacheKey($identifier->getType()) . '#name:' . $identifier->getName();
    }
    private function identifierTypeToCacheKey(\_PhpScopera143bcca66cb\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : string
    {
        return 'type:' . $identifierType->getName();
    }
}
