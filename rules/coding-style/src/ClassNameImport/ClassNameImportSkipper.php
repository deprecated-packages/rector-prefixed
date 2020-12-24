<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function shouldSkipNameForFullyQualifiedObjectType(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : bool
    {
        foreach ($this->classNameImportSkipVoters as $classNameImportSkipVoter) {
            if ($classNameImportSkipVoter->shouldSkip($fullyQualifiedObjectType, $node)) {
                return \true;
            }
        }
        return \false;
    }
    public function isShortNameInUseStatement(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : bool
    {
        $longName = $name->toString();
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($longName, '\\')) {
            return \false;
        }
        return $this->isFoundInUse($name);
    }
    private function isFoundInUse(\_PhpScopere8e811afab72\PhpParser\Node\Name $name) : bool
    {
        /** @var Use_[] $uses */
        $uses = (array) $name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        foreach ($uses as $use) {
            $useUses = $use->uses;
            foreach ($useUses as $useUse) {
                if ($useUse->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name && $useUse->name->getLast() === $name->getLast()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
