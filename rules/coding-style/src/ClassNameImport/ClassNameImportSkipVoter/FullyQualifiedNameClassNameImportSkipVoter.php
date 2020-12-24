<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * SomeClass::callThis();
 */
final class FullyQualifiedNameClassNameImportSkipVoter implements \_PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var ShortNameResolver
     */
    private $shortNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
    }
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        // "new X" or "X::static()"
        $shortNames = $this->shortNameResolver->resolveForNode($node);
        foreach ($shortNames as $shortName => $fullyQualifiedName) {
            $shortNameLowered = \strtolower($shortName);
            if ($fullyQualifiedObjectType->getShortNameLowered() !== $shortNameLowered) {
                continue;
            }
            return $fullyQualifiedObjectType->getClassNameLowered() !== \strtolower($fullyQualifiedName);
        }
        return \false;
    }
}
