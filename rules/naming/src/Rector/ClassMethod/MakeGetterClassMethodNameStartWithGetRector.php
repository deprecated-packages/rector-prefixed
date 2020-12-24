<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\MethodNameResolver;
use _PhpScoperb75b35f52b74\Rector\Naming\NodeRenamer\MethodCallRenamer;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector\MakeGetterClassMethodNameStartWithGetRectorTest
 */
final class MakeGetterClassMethodNameStartWithGetRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const GETTER_NAME_PATTERN = '#^(is|should|has|was|must|get|provide|__)#';
    /**
     * @var MethodNameResolver
     */
    private $methodNameResolver;
    /**
     * @var MethodCallRenamer
     */
    private $methodCallRenamer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Naming\MethodNameResolver $methodNameResolver, \_PhpScoperb75b35f52b74\Rector\Naming\NodeRenamer\MethodCallRenamer $methodCallRenamer)
    {
        $this->methodNameResolver = $methodNameResolver;
        $this->methodCallRenamer = $methodCallRenamer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getter method names to start with get/provide', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string
     */
    private $name;

    public function name(): string
    {
        return $this->name;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string
     */
    private $name;

    public function getName(): string
    {
        return $this->name;
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->isAlreadyGetterNamedClassMethod($node)) {
            return null;
        }
        $getterClassMethodReturnedExpr = $this->matchGetterClassMethodReturnedExpr($node);
        if ($getterClassMethodReturnedExpr === null) {
            return null;
        }
        $getterMethodName = $this->methodNameResolver->resolveGetterFromReturnedExpr($getterClassMethodReturnedExpr);
        if ($getterMethodName === null) {
            return null;
        }
        if ($this->isName($node->name, $getterMethodName)) {
            return null;
        }
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($getterMethodName);
        $this->methodCallRenamer->updateClassMethodCalls($node, $getterMethodName);
        return $node;
    }
    private function isAlreadyGetterNamedClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->isName($classMethod, self::GETTER_NAME_PATTERN);
    }
    private function matchGetterClassMethodReturnedExpr(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $stmts[0] ?? null;
        if (!$onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$onlyStmt->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyStaticType = $this->getStaticType($onlyStmt->expr);
        // is handled by boolish Rector → skip here
        if ($propertyStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType) {
            return null;
        }
        return $onlyStmt->expr;
    }
}
