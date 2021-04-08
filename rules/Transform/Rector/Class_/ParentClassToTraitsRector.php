<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\NodeManipulator\ClassInsertManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Transform\ValueObject\ParentClassToTraits;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210408\Webmozart\Assert\Assert;
/**
 * Can handle cases like:
 * - https://doc.nette.org/en/2.4/migration-2-4#toc-nette-smartobject
 * - https://github.com/silverstripe/silverstripe-upgrader/issues/71#issue-320145944
 *
 * @see \Rector\Tests\Transform\Rector\Class_\ParentClassToTraitsRector\ParentClassToTraitsRectorTest
 */
final class ParentClassToTraitsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PARENT_CLASS_TO_TRAITS = 'parent_class_to_traits';
    /**
     * @var ParentClassToTraits[]
     */
    private $parentClassToTraits = [];
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\Rector\Core\NodeManipulator\ClassInsertManipulator $classInsertManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces parent class to specific traits', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::PARENT_CLASS_TO_TRAITS => ['Nette\\Object' => ['Nette\\SmartObject']]])]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->extends === null) {
            return null;
        }
        if ($node->isAnonymous()) {
            return null;
        }
        foreach ($this->parentClassToTraits as $parentClassToTrait) {
            if (!$this->isObjectType($node, $parentClassToTrait->getParentObjectType())) {
                continue;
            }
            foreach ($parentClassToTrait->getTraitNames() as $traitName) {
                $this->classInsertManipulator->addAsFirstTrait($node, $traitName);
            }
            $this->removeParentClass($node);
            return $node;
        }
        return null;
    }
    /**
     * @param array<string, ParentClassToTraits[]> $configuration
     */
    public function configure(array $configuration) : void
    {
        $parentClassToTraits = $configuration[self::PARENT_CLASS_TO_TRAITS] ?? [];
        \RectorPrefix20210408\Webmozart\Assert\Assert::allIsInstanceOf($parentClassToTraits, \Rector\Transform\ValueObject\ParentClassToTraits::class);
        $this->parentClassToTraits = $parentClassToTraits;
    }
    private function removeParentClass(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = null;
    }
}
