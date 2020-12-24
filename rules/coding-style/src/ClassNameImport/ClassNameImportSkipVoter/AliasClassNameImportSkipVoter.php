<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\AliasUsesResolver;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * use App\Something as SomeClass;
 */
final class AliasClassNameImportSkipVoter implements \_PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var AliasUsesResolver
     */
    private $aliasUsesResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\AliasUsesResolver $aliasUsesResolver)
    {
        $this->aliasUsesResolver = $aliasUsesResolver;
    }
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $aliasedUses = $this->aliasUsesResolver->resolveForNode($node);
        foreach ($aliasedUses as $aliasedUse) {
            $aliasedUseLowered = \strtolower($aliasedUse);
            // its aliased, we cannot just rename it
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($aliasedUseLowered, '\\' . $fullyQualifiedObjectType->getShortNameLowered())) {
                return \true;
            }
        }
        return \false;
    }
}
