<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveEmptyAbstractClassRector\RemoveEmptyAbstractClassRectorTest
 */
final class RemoveEmptyAbstractClassRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @return string[]
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        return $this->processRemove($node);
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Empty abstract class that does nothing', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass extends SomeAbstractClass
{
}

abstract class SomeAbstractClass extends AnotherAbstractClass
{
}

abstract class AnotherAbstractClass
{
     public function getName()
     {
        return 'name';
     }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass extends AnotherAbstractClass
{
}

abstracst clas AnotherAbstractClass
{
     public function getName()
     {
          return 'cowo';
     }
}
CODE_SAMPLE
)]);
    }
    private function shouldSkip(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$class->isAbstract()) {
            return \true;
        }
        if ($class->implements !== []) {
            return \true;
        }
        $stmts = $class->stmts;
        return $stmts !== [];
    }
    private function processRemove(\PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Stmt\Class_
    {
        $className = $this->getName($class->namespacedName);
        $names = $this->nodeRepository->findNames($className);
        foreach ($names as $name) {
            $parent = $name->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parent instanceof \PhpParser\Node\Stmt\Class_) {
                return null;
            }
        }
        $children = $this->nodeRepository->findChildrenOfClass($this->getName($class->namespacedName));
        $extends = $class->extends;
        foreach ($children as $child) {
            $child->extends = $extends;
        }
        $this->removeNode($class);
        return $class;
    }
}
