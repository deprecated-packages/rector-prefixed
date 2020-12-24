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
 * class SomeClass {}
 */
final class ClassLikeNameClassNameImportSkipVoter implements \_PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
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
        $classLikeNames = $this->shortNameResolver->resolveShortClassLikeNamesForNode($node);
        foreach ($classLikeNames as $classLikeName) {
            if (\strtolower($classLikeName) === $fullyQualifiedObjectType->getShortNameLowered()) {
                return \true;
            }
        }
        return \false;
    }
}
