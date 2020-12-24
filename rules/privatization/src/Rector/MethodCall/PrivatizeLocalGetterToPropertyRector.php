<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Privatization\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector\PrivatizeLocalGetterToPropertyRectorTest
 */
final class PrivatizeLocalGetterToPropertyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Privatize getter of local property to property', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private $some;

    public function run()
    {
        return $this->getSome() + 5;
    }

    private function getSome()
    {
        return $this->some;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    private $some;

    public function run()
    {
        return $this->some + 5;
    }

    private function getSome()
    {
        return $this->some;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isVariableName($node->var, 'this')) {
            return null;
        }
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        /** @var ClassMethod|null $classMethod */
        $classMethod = $classLike->getMethod($methodName);
        if ($classMethod === null) {
            return null;
        }
        return $this->matchLocalPropertyFetchInGetterMethod($classMethod);
    }
    private function matchLocalPropertyFetchInGetterMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $stmts[0] ?? null;
        if (!$onlyStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$onlyStmt->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        return $onlyStmt->expr;
    }
}
