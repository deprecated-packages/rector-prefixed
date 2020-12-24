<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * SomeClass::callThis();
 */
final class FullyQualifiedNameClassNameImportSkipVoter implements \_PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var ShortNameResolver
     */
    private $shortNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
    }
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool
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
