<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ThisType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Reflection\ClassReflectionToAstResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\MethodCall\RemoveEmptyMethodCallRector\RemoveEmptyMethodCallRectorTest
 */
final class RemoveEmptyMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassReflectionToAstResolver
     */
    private $classReflectionToAstResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Reflection\ClassReflectionToAstResolver $classReflectionToAstResolver)
    {
        $this->classReflectionToAstResolver = $classReflectionToAstResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove empty method call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function callThis()
    {
    }
}

$some = new SomeClass();
$some->callThis();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function callThis()
    {
    }
}

$some = new SomeClass();
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Scope|null $scope */
        $scope = $node->var->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $type = $scope->getType($node->var);
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ThisType) {
            $type = $type->getStaticObjectType();
        }
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return null;
        }
        $class = $this->classReflectionToAstResolver->getClassFromObjectType($type);
        if ($class === null) {
            return null;
        }
        if ($this->shouldSkipClassMethod($class, $node)) {
            return null;
        }
        // if->cond cannot removed, it has to be replaced with false, see https://3v4l.org/U9S9i
        $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ && $parent->cond === $node) {
            return $this->createFalse();
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return $this->createFalse();
        }
        $this->removeNode($node);
        return $node;
    }
    private function shouldSkipClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $methodName = $this->getName($methodCall->name);
        if ($methodName === null) {
            return \true;
        }
        $classMethod = $class->getMethod($methodName);
        if ($classMethod === null) {
            return \true;
        }
        if ($classMethod->isAbstract()) {
            return \true;
        }
        return \count((array) $classMethod->stmts) !== 0;
    }
}
