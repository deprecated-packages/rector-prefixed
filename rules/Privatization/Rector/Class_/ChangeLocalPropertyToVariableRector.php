<?php

declare (strict_types=1);
namespace Rector\Privatization\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Privatization\NodeAnalyzer\PropertyFetchByMethodAnalyzer;
use Rector\Privatization\NodeReplacer\PropertyFetchWithVariableReplacer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector\ChangeLocalPropertyToVariableRectorTest
 */
final class ChangeLocalPropertyToVariableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var PropertyFetchWithVariableReplacer
     */
    private $propertyFetchWithVariableReplacer;
    /**
     * @var PropertyFetchByMethodAnalyzer
     */
    private $propertyFetchByMethodAnalyzer;
    public function __construct(\Rector\Core\NodeManipulator\ClassManipulator $classManipulator, \Rector\Privatization\NodeReplacer\PropertyFetchWithVariableReplacer $propertyFetchWithVariableReplacer, \Rector\Privatization\NodeAnalyzer\PropertyFetchByMethodAnalyzer $propertyFetchByMethodAnalyzer)
    {
        $this->classManipulator = $classManipulator;
        $this->propertyFetchWithVariableReplacer = $propertyFetchWithVariableReplacer;
        $this->propertyFetchByMethodAnalyzer = $propertyFetchByMethodAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change local property used in single method to local variable', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private $count;
    public function run()
    {
        $this->count = 5;
        return $this->count;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $count = 5;
        return $count;
    }
}
CODE_SAMPLE
)]);
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
     * @return \PhpParser\Node|null
     */
    public function refactor(\PhpParser\Node $node)
    {
        if ($this->classAnalyzer->isAnonymousClass($node)) {
            return null;
        }
        $privatePropertyNames = $this->classManipulator->getPrivatePropertyNames($node);
        $propertyUsageByMethods = $this->propertyFetchByMethodAnalyzer->collectPropertyFetchByMethods($node, $privatePropertyNames);
        if ($propertyUsageByMethods === []) {
            return null;
        }
        foreach ($propertyUsageByMethods as $propertyName => $methodNames) {
            if (\count($methodNames) === 1) {
                continue;
            }
            unset($propertyUsageByMethods[$propertyName]);
        }
        $this->propertyFetchWithVariableReplacer->replacePropertyFetchesByVariable($node, $propertyUsageByMethods);
        // remove properties
        foreach ($node->getProperties() as $property) {
            $classMethodNames = \array_keys($propertyUsageByMethods);
            if (!$this->isNames($property, $classMethodNames)) {
                continue;
            }
            $this->removeNode($property);
        }
        return $node;
    }
}
