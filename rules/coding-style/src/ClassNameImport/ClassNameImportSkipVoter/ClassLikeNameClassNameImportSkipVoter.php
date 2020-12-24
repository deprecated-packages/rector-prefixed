<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ClassNameImportSkipVoter;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ShortNameResolver;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * Prevents adding:
 *
 * use App\SomeClass;
 *
 * If there is already:
 *
 * class SomeClass {}
 */
final class ClassLikeNameClassNameImportSkipVoter implements \_PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface
{
    /**
     * @var ShortNameResolver
     */
    private $shortNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport\ShortNameResolver $shortNameResolver)
    {
        $this->shortNameResolver = $shortNameResolver;
    }
    public function shouldSkip(\_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
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
