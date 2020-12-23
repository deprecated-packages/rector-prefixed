<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ThisType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\Reflection\ClassReflectionToAstResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\MethodCall\RemoveEmptyMethodCallRector\RemoveEmptyMethodCallRectorTest
 */
final class RemoveEmptyMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassReflectionToAstResolver
     */
    private $classReflectionToAstResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\Reflection\ClassReflectionToAstResolver $classReflectionToAstResolver)
    {
        $this->classReflectionToAstResolver = $classReflectionToAstResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove empty method call', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var Scope|null $scope */
        $scope = $node->var->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($scope === null) {
            return null;
        }
        $type = $scope->getType($node->var);
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType) {
            $type = $type->getStaticObjectType();
        }
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
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
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ && $parent->cond === $node) {
            return $this->createFalse();
        }
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return $this->createFalse();
        }
        $this->removeNode($node);
        return $node;
    }
    private function shouldSkipClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
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
