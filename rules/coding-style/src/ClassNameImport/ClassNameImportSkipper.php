<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ClassNameImport;

use RectorPrefix20201229\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Use_;
use Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
final class ClassNameImportSkipper
{
    /**
     * @var ClassNameImportSkipVoterInterface[]
     */
    private $classNameImportSkipVoters = [];
    /**
     * @param ClassNameImportSkipVoterInterface[] $classNameImportSkipVoters
     */
    public function __construct(array $classNameImportSkipVoters)
    {
        $this->classNameImportSkipVoters = $classNameImportSkipVoters;
    }
    public function shouldSkipNameForFullyQualifiedObjectType(\PhpParser\Node $node, \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : bool
    {
        foreach ($this->classNameImportSkipVoters as $classNameImportSkipVoter) {
            if ($classNameImportSkipVoter->shouldSkip($fullyQualifiedObjectType, $node)) {
                return \true;
            }
        }
        return \false;
    }
    public function isShortNameInUseStatement(\PhpParser\Node\Name $name) : bool
    {
        $longName = $name->toString();
        if (\RectorPrefix20201229\Nette\Utils\Strings::contains($longName, '\\')) {
            return \false;
        }
        return $this->isFoundInUse($name);
    }
    private function isFoundInUse(\PhpParser\Node\Name $name) : bool
    {
        /** @var Use_[] $uses */
        $uses = (array) $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        foreach ($uses as $use) {
            $useUses = $use->uses;
            foreach ($useUses as $useUse) {
                if ($useUse->name instanceof \PhpParser\Node\Name && $useUse->name->getLast() === $name->getLast()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
