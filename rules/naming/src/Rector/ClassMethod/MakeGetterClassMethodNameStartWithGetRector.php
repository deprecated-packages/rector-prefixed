<?php

declare (strict_types=1);
namespace Rector\Naming\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\BooleanType;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Naming\MethodNameResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\ClassMethod\MakeGetterClassMethodNameStartWithGetRector\MakeGetterClassMethodNameStartWithGetRectorTest
 */
final class MakeGetterClassMethodNameStartWithGetRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const GETTER_NAME_PATTERN = '#^(is|should|has|was|must|get|provide|__)#';
    /**
     * @var MethodNameResolver
     */
    private $methodNameResolver;
    public function __construct(\Rector\Naming\Naming\MethodNameResolver $methodNameResolver)
    {
        $this->methodNameResolver = $methodNameResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getter method names to start with get/provide', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
        $node->name = new \PhpParser\Node\Identifier($getterMethodName);
        $this->updateClassMethodCalls($node, $getterMethodName);
        return $node;
    }
    private function isAlreadyGetterNamedClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->isName($classMethod, self::GETTER_NAME_PATTERN);
    }
    private function matchGetterClassMethodReturnedExpr(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr
    {
        if (\count((array) $classMethod->stmts) !== 1) {
            return null;
        }
        $onlyStmt = $classMethod->stmts[0];
        if (!$onlyStmt instanceof \PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$onlyStmt->expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyStaticType = $this->getStaticType($onlyStmt->expr);
        // is handled by boolish Rector → skip here
        if ($propertyStaticType instanceof \PHPStan\Type\BooleanType) {
            return null;
        }
        return $onlyStmt->expr;
    }
    private function updateClassMethodCalls(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $newClassMethodName) : void
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->nodeRepository->findCallsByClassMethod($classMethod);
        foreach ($methodCalls as $methodCall) {
            $methodCall->name = new \PhpParser\Node\Identifier($newClassMethodName);
        }
    }
}
