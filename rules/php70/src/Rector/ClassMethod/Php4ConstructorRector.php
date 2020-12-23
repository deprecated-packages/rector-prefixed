<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/remove_php4_constructors
 * @see \Rector\Php70\Tests\Rector\ClassMethod\Php4ConstructorRector\Php4ConstructorRectorTest
 */
final class Php4ConstructorRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes PHP 4 style constructor to __construct.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function SomeClass()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct()
    {
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        // process parent call references first
        $this->processClassMethodStatementsForParentConstructorCalls($node);
        // not PSR-4 constructor
        if (!$this->isName($classLike, $this->getName($node))) {
            return null;
        }
        $classMethod = $classLike->getMethod(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        // does it already have a __construct method?
        if ($classMethod === null) {
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
        }
        if ($node->stmts === null) {
            return null;
        }
        if (\count((array) $node->stmts) === 1) {
            /** @var Expression $stmt */
            $stmt = $node->stmts[0];
            if ($this->isLocalMethodCallNamed($stmt->expr, \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT)) {
                $this->removeNode($node);
                return null;
            }
        }
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $namespace = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        // catch only classes without namespace
        if ($namespace !== null) {
            return \true;
        }
        if ($classMethod->isAbstract() || $classMethod->isStatic()) {
            return \true;
        }
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classLike->name === null;
    }
    private function processClassMethodStatementsForParentConstructorCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!\is_iterable($classMethod->stmts)) {
            return;
        }
        /** @var Expression $methodStmt */
        foreach ($classMethod->stmts as $methodStmt) {
            if ($methodStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                $methodStmt = $methodStmt->expr;
            }
            if (!$methodStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            $this->processParentPhp4ConstructCall($methodStmt);
        }
    }
    private function processParentPhp4ConstructCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $parentClassName = $staticCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        // no parent class
        if (!\is_string($parentClassName)) {
            return;
        }
        if (!$staticCall->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return;
        }
        // rename ParentClass
        if ($this->isName($staticCall->class, $parentClassName)) {
            $staticCall->class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('parent');
        }
        if (!$this->isName($staticCall->class, 'parent')) {
            return;
        }
        // it's not a parent PHP 4 constructor call
        if (!$this->isName($staticCall->name, $parentClassName)) {
            return;
        }
        $staticCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier(\_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
    }
}
