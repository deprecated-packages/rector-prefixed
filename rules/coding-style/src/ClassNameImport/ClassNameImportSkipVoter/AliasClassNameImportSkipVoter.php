<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * use App\Something as SomeClass;
 */
final class AliasClassNameImportSkipVoter implements \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver)
    {
        $this->aliasUsesResolver = $aliasUsesResolver;
    }
    public function shouldSkip(\_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $aliasedUses = $this->aliasUsesResolver->resolveForNode($node);
        foreach ($aliasedUses as $aliasedUse) {
            $aliasedUseLowered = \strtolower($aliasedUse);
            // its aliased, we cannot just rename it
            if (\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::endsWith($aliasedUseLowered, '\\' . $fullyQualifiedObjectType->getShortNameLowered())) {
                return \true;
            }
        }
        return \false;
    }
}
