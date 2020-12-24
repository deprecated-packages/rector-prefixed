<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Can handle cases like:
 * - https://doc.nette.org/en/2.4/migration-2-4#toc-nette-smartobject
 * - https://github.com/silverstripe/silverstripe-upgrader/issues/71#issue-320145944
 *
 * @see \Rector\Generic\Tests\Rector\Class_\ParentClassToTraitsRector\ParentClassToTraitsRectorTest
 */
final class ParentClassToTraitsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PARENT_CLASS_TO_TRAITS = '$parentClassToTraits';
    /**
     * @var string[][] { parent class => [ traits ] }
     */
    private $parentClassToTraits = [];
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces parent class to specific traits', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass extends Nette\Object
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    use Nette\SmartObject;
}
CODE_SAMPLE
, [self::PARENT_CLASS_TO_TRAITS => ['_PhpScopere8e811afab72\\Nette\\Object' => ['_PhpScopere8e811afab72\\Nette\\SmartObject']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->extends === null || $node->isAnonymous()) {
            return null;
        }
        $nodeParentClassName = $this->getName($node->extends);
        if (!isset($this->parentClassToTraits[$nodeParentClassName])) {
            return null;
        }
        $traitNames = $this->parentClassToTraits[$nodeParentClassName];
        // keep the Trait order the way it is in config
        $traitNames = \array_reverse($traitNames);
        foreach ($traitNames as $traitName) {
            $this->classInsertManipulator->addAsFirstTrait($node, $traitName);
        }
        $this->removeParentClass($node);
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->parentClassToTraits = $configuration[self::PARENT_CLASS_TO_TRAITS] ?? [];
    }
    private function removeParentClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = null;
    }
}
