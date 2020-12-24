<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Class_\AddInterfaceByTraitRector\AddInterfaceByTraitRectorTest
 */
final class AddInterfaceByTraitRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const INTERFACE_BY_TRAIT = '$interfaceByTrait';
    /**
     * @var string[]
     */
    private $interfaceByTrait = [];
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator)
    {
        $this->classManipulator = $classManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add interface by used trait', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    use SomeTrait;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass implements SomeInterface
{
    use SomeTrait;
}
CODE_SAMPLE
, [self::INTERFACE_BY_TRAIT => ['SomeTrait' => 'SomeInterface']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->isAnonymousClass($node)) {
            return null;
        }
        $usedTraitNames = $this->classManipulator->getUsedTraits($node);
        if ($usedTraitNames === []) {
            return null;
        }
        $implementedInterfaceNames = $this->classManipulator->getImplementedInterfaceNames($node);
        foreach (\array_keys($usedTraitNames) as $traitName) {
            if (!isset($this->interfaceByTrait[$traitName])) {
                continue;
            }
            $interfaceNameToAdd = $this->interfaceByTrait[$traitName];
            if (\in_array($interfaceNameToAdd, $implementedInterfaceNames, \true)) {
                continue;
            }
            $node->implements[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($interfaceNameToAdd);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->interfaceByTrait = $configuration[self::INTERFACE_BY_TRAIT] ?? [];
    }
}
