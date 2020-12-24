<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ClassNameImport;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Contract\ClassNameImport\ClassNameImportSkipVoterInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType;
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
    public function shouldSkipNameForFullyQualifiedObjectType(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\FullyQualifiedObjectType $fullyQualifiedObjectType) : bool
    {
        foreach ($this->classNameImportSkipVoters as $classNameImportSkipVoter) {
            if ($classNameImportSkipVoter->shouldSkip($fullyQualifiedObjectType, $node)) {
                return \true;
            }
        }
        return \false;
    }
    public function isShortNameInUseStatement(\_PhpScoper0a6b37af0871\PhpParser\Node\Name $name) : bool
    {
        $longName = $name->toString();
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($longName, '\\')) {
            return \false;
        }
        return $this->isFoundInUse($name);
    }
    private function isFoundInUse(\_PhpScoper0a6b37af0871\PhpParser\Node\Name $name) : bool
    {
        /** @var Use_[] $uses */
        $uses = (array) $name->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::USE_NODES);
        foreach ($uses as $use) {
            $useUses = $use->uses;
            foreach ($useUses as $useUse) {
                if ($useUse->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && $useUse->name->getLast() === $name->getLast()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
