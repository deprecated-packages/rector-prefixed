<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * use App\Something as SomeClass;
 */
final class AliasClassNameImportSkipVoter implements \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver)
    {
        $this->aliasUsesResolver = $aliasUsesResolver;
    }
    public function shouldSkip(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $aliasedUses = $this->aliasUsesResolver->resolveForNode($node);
        foreach ($aliasedUses as $aliasedUse) {
            $aliasedUseLowered = \strtolower($aliasedUse);
            // its aliased, we cannot just rename it
            if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::endsWith($aliasedUseLowered, '\\' . $fullyQualifiedObjectType->getShortNameLowered())) {
                return \true;
            }
        }
        return \false;
    }
}
