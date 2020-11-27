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
 * @see \Rector\Naming\Tests\Rector\ClassMethod\MakeIsserClassMethodNameStartWithIsRector\MakeIsserClassMethodNameStartWithIsRectorTest
 */
final class MakeIsserClassMethodNameStartWithIsRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @see https://regex101.com/r/Hc73ar/1
     * @var string
     */
    private const ISSER_NAME_REGEX = '#^(is|has|was|must|does|have|should|__)#';
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
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change is method names to start with is/has/was', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var bool
     */
    private $isActive = false;

    public function getIsActive()
    {
        return $this->isActive;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var bool
     */
    private $isActive = false;

    public function isActive()
    {
        return $this->isActive;
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
        if ($this->isAlreadyIsserNamedClassMethod($node)) {
            return null;
        }
        $getterClassMethodReturnedExpr = $this->matchIsserClassMethodReturnedExpr($node);
        if ($getterClassMethodReturnedExpr === null) {
            return null;
        }
        $isserMethodName = $this->methodNameResolver->resolveIsserFromReturnedExpr($getterClassMethodReturnedExpr);
        if ($isserMethodName === null) {
            return null;
        }
        if ($this->isName($node->name, $isserMethodName)) {
            return null;
        }
        $node->name = new \PhpParser\Node\Identifier($isserMethodName);
        $this->updateClassMethodCalls($node, $isserMethodName);
        return $node;
    }
    private function isAlreadyIsserNamedClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->isName($classMethod, self::ISSER_NAME_REGEX);
    }
    private function matchIsserClassMethodReturnedExpr(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr
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
        if (!$propertyStaticType instanceof \PHPStan\Type\BooleanType) {
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
