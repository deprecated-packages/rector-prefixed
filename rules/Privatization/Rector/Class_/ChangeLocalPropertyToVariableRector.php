<?php

declare (strict_types=1);
namespace Rector\Privatization\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\Else_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\While_;
use PhpParser\NodeTraverser;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\NodeManipulator\ClassManipulator;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Privatization\NodeReplacer\PropertyFetchWithVariableReplacer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector\ChangeLocalPropertyToVariableRectorTest
 */
final class ChangeLocalPropertyToVariableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<class-string<Stmt>>
     */
    private const SCOPE_CHANGING_NODE_TYPES = [\PhpParser\Node\Stmt\Do_::class, \PhpParser\Node\Stmt\While_::class, \PhpParser\Node\Stmt\If_::class, \PhpParser\Node\Stmt\Else_::class];
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var PropertyFetchWithVariableReplacer
     */
    private $propertyFetchWithVariableReplacer;
    public function __construct(\Rector\Core\NodeManipulator\ClassManipulator $classManipulator, \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \Rector\Privatization\NodeReplacer\PropertyFetchWithVariableReplacer $propertyFetchWithVariableReplacer)
    {
        $this->classManipulator = $classManipulator;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->propertyFetchWithVariableReplacer = $propertyFetchWithVariableReplacer;
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
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->classAnalyzer->isAnonymousClass($node)) {
            return null;
        }
        $privatePropertyNames = $this->classManipulator->getPrivatePropertyNames($node);
        $propertyUsageByMethods = $this->collectPropertyFetchByMethods($node, $privatePropertyNames);
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
    /**
     * @param string[] $privatePropertyNames
     * @return array<string, string[]>
     */
    private function collectPropertyFetchByMethods(\PhpParser\Node\Stmt\Class_ $class, array $privatePropertyNames) : array
    {
        $propertyUsageByMethods = [];
        foreach ($privatePropertyNames as $privatePropertyName) {
            foreach ($class->getMethods() as $classMethod) {
                // assigned in constructor injection → skip
                if ($this->isName($classMethod, \Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                    return [];
                }
                if (!$this->propertyFetchAnalyzer->containsLocalPropertyFetchName($classMethod, $privatePropertyName)) {
                    continue;
                }
                if ($this->isPropertyChangingInMultipleMethodCalls($classMethod, $privatePropertyName)) {
                    continue;
                }
                /** @var string $classMethodName */
                $classMethodName = $this->getName($classMethod);
                $propertyUsageByMethods[$privatePropertyName][] = $classMethodName;
            }
        }
        return $propertyUsageByMethods;
    }
    /**
     * Covers https://github.com/rectorphp/rector/pull/2558#discussion_r363036110
     */
    private function isPropertyChangingInMultipleMethodCalls(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : bool
    {
        $isPropertyChanging = \false;
        $isPropertyReadInIf = \false;
        $isIfFollowedByAssign = \false;
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\PhpParser\Node $node) use(&$isPropertyChanging, $propertyName, &$isPropertyReadInIf, &$isIfFollowedByAssign) : ?int {
            if ($isPropertyReadInIf) {
                if (!$this->propertyFetchAnalyzer->isLocalPropertyOfNames($node, [$propertyName])) {
                    return null;
                }
                $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                if ($parentNode instanceof \PhpParser\Node\Expr\Assign && $parentNode->var === $node) {
                    $isIfFollowedByAssign = \true;
                }
            }
            if (!$this->isScopeChangingNode($node)) {
                return null;
            }
            if ($node instanceof \PhpParser\Node\Stmt\If_) {
                $isPropertyReadInIf = $this->refactorIf($node, $propertyName);
            }
            $isPropertyChanging = $this->isPropertyChanging($node, $propertyName);
            if (!$isPropertyChanging) {
                return null;
            }
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyChanging || $isIfFollowedByAssign || $isPropertyReadInIf;
    }
    private function isScopeChangingNode(\PhpParser\Node $node) : bool
    {
        foreach (self::SCOPE_CHANGING_NODE_TYPES as $type) {
            if (\is_a($node, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function refactorIf(\PhpParser\Node\Stmt\If_ $if, string $privatePropertyName) : ?bool
    {
        $this->traverseNodesWithCallable($if->cond, function (\PhpParser\Node $node) use($privatePropertyName, &$isPropertyReadInIf) : ?int {
            if (!$this->propertyFetchAnalyzer->isLocalPropertyOfNames($node, [$privatePropertyName])) {
                return null;
            }
            $isPropertyReadInIf = \true;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyReadInIf;
    }
    private function isPropertyChanging(\PhpParser\Node $node, string $privatePropertyName) : bool
    {
        $isPropertyChanging = \false;
        // here cannot be any property assign
        $this->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use(&$isPropertyChanging, $privatePropertyName) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->isName($node->var->name, $privatePropertyName)) {
                return null;
            }
            $isPropertyChanging = \true;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyChanging;
    }
}
