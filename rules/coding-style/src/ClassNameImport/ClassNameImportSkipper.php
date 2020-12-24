<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function shouldSkipNameForFullyQualifiedObjectType(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : bool
    {
        foreach ($this->classNameImportSkipVoters as $classNameImportSkipVoter) {
            if ($classNameImportSkipVoter->shouldSkip($fullyQualifiedObjectType, $node)) {
                return \true;
            }
        }
        return \false;
    }
    public function isShortNameInUseStatement(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        $longName = $name->toString();
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($longName, '\\')) {
            return \false;
        }
        return $this->isFoundInUse($name);
    }
    private function isFoundInUse(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : bool
    {
        /** @var Use_[] $uses */
        $uses = (array) $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        foreach ($uses as $use) {
            $useUses = $use->uses;
            foreach ($useUses as $useUse) {
                if ($useUse->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name && $useUse->name->getLast() === $name->getLast()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
