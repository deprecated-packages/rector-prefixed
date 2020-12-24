<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * use App\Something as SomeClass;
 */
final class AliasClassNameImportSkipVoter implements \_PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver)
    {
        $this->aliasUsesResolver = $aliasUsesResolver;
    }
    public function shouldSkip(\_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $aliasedUses = $this->aliasUsesResolver->resolveForNode($node);
        foreach ($aliasedUses as $aliasedUse) {
            $aliasedUseLowered = \strtolower($aliasedUse);
            // its aliased, we cannot just rename it
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($aliasedUseLowered, '\\' . $fullyQualifiedObjectType->getShortNameLowered())) {
                return \true;
            }
        }
        return \false;
    }
}
