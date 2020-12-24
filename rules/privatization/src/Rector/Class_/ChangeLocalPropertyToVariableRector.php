<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Privatization\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Else_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\Class_\ChangeLocalPropertyToVariableRector\ChangeLocalPropertyToVariableRectorTest
 */
final class ChangeLocalPropertyToVariableRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const SCOPE_CHANGING_NODE_TYPES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Else_::class];
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->classManipulator = $classManipulator;
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change local property used in single method to local variable', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->isAnonymousClass($node)) {
            return null;
        }
        $privatePropertyNames = $this->classManipulator->getPrivatePropertyNames($node);
        $propertyUsageByMethods = $this->collectPropertyFetchByMethods($node, $privatePropertyNames);
        foreach ($propertyUsageByMethods as $propertyName => $methodNames) {
            if (\count($methodNames) === 1) {
                continue;
            }
            unset($propertyUsageByMethods[$propertyName]);
        }
        $this->replacePropertyFetchesByLocalProperty($node, $propertyUsageByMethods);
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
     * @return string[][]
     */
    private function collectPropertyFetchByMethods(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $privatePropertyNames) : array
    {
        $propertyUsageByMethods = [];
        foreach ($privatePropertyNames as $privatePropertyName) {
            foreach ($class->getMethods() as $classMethod) {
                $hasProperty = (bool) $this->betterNodeFinder->findFirst($classMethod, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($privatePropertyName) : bool {
                    if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                        return \false;
                    }
                    return (bool) $this->isName($node->name, $privatePropertyName);
                });
                if (!$hasProperty) {
                    continue;
                }
                $isPropertyChangingInMultipleMethodCalls = $this->isPropertyChangingInMultipleMethodCalls($classMethod, $privatePropertyName);
                if ($isPropertyChangingInMultipleMethodCalls) {
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
     * @param string[][] $propertyUsageByMethods
     */
    private function replacePropertyFetchesByLocalProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, array $propertyUsageByMethods) : void
    {
        foreach ($propertyUsageByMethods as $propertyName => $methodNames) {
            $methodName = $methodNames[0];
            $classMethod = $class->getMethod($methodName);
            if ($classMethod === null) {
                continue;
            }
            $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName) : ?Variable {
                if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                    return null;
                }
                if (!$this->isName($node, $propertyName)) {
                    return null;
                }
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($propertyName);
            });
        }
    }
    /**
     * Covers https://github.com/rectorphp/rector/pull/2558#discussion_r363036110
     */
    private function isPropertyChangingInMultipleMethodCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, string $privatePropertyName) : bool
    {
        $isPropertyChanging = \false;
        $isPropertyReadInIf = \false;
        $isIfFollowedByAssign = \false;
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$isPropertyChanging, $privatePropertyName, &$isPropertyReadInIf, &$isIfFollowedByAssign) : ?int {
            if ($isPropertyReadInIf) {
                if (!$this->propertyFetchManipulator->isLocalPropertyOfNames($node, [$privatePropertyName])) {
                    return null;
                }
                $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
                if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && $parentNode->var === $node) {
                    $isIfFollowedByAssign = \true;
                }
            }
            if (!$this->isScopeChangingNode($node)) {
                return null;
            }
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
                $isPropertyReadInIf = $this->refactorIf($node, $privatePropertyName);
            }
            $isPropertyChanging = $this->isPropertyChanging($node, $this, $privatePropertyName);
            if (!$isPropertyChanging) {
                return null;
            }
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyChanging || $isIfFollowedByAssign;
    }
    private function isScopeChangingNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        foreach (self::SCOPE_CHANGING_NODE_TYPES as $scopeChangingNode) {
            if (!\is_a($node, $scopeChangingNode, \true)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function refactorIf(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if, string $privatePropertyName) : ?bool
    {
        $this->traverseNodesWithCallable($if->cond, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($privatePropertyName, &$isPropertyReadInIf) : ?int {
            if (!$this->propertyFetchManipulator->isLocalPropertyOfNames($node, [$privatePropertyName])) {
                return null;
            }
            $isPropertyReadInIf = \true;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyReadInIf;
    }
    private function isPropertyChanging(\_PhpScoperb75b35f52b74\PhpParser\Node $node, self $this__, string $privatePropertyName) : bool
    {
        $isPropertyChanging = \false;
        // here cannot be any property assign
        $this__->traverseNodesWithCallable($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$isPropertyChanging, $privatePropertyName) : ?int {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return null;
            }
            if (!$this->isName($node->var->name, $privatePropertyName)) {
                return null;
            }
            $isPropertyChanging = \true;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $isPropertyChanging;
    }
}
