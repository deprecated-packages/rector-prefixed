<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * use App\Something as SomeClass;
 */
final class AliasClassNameImportSkipVoter implements \_PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver)
    {
        $this->aliasUsesResolver = $aliasUsesResolver;
    }
    public function shouldSkip(\_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $aliasedUses = $this->aliasUsesResolver->resolveForNode($node);
        foreach ($aliasedUses as $aliasedUse) {
            $aliasedUseLowered = \strtolower($aliasedUse);
            // its aliased, we cannot just rename it
            if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($aliasedUseLowered, '\\' . $fullyQualifiedObjectType->getShortNameLowered())) {
                return \true;
            }
        }
        return \false;
    }
}
