<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Comment\Doc;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Php\TypeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
/**
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class PhpSpecMocksToPHPUnitMocksRector extends \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var PhpSpecMockCollector
     */
    private $phpSpecMockCollector;
    /**
     * @var TypeAnalyzer
     */
    private $typeAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector $phpSpecMockCollector, \_PhpScopere8e811afab72\Rector\Core\Php\TypeAnalyzer $typeAnalyzer)
    {
        $this->phpSpecMockCollector = $phpSpecMockCollector;
        $this->typeAnalyzer = $typeAnalyzer;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param ClassMethod|MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            // public = tests, protected = internal, private = own (no framework magic)
            if ($node->isPrivate()) {
                return null;
            }
            $this->processMethodParamsToMocks($node);
            return $node;
        }
        return $this->processMethodCall($node);
    }
    private function processMethodParamsToMocks(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // remove params and turn them to instances
        $assigns = [];
        foreach ((array) $classMethod->params as $param) {
            if (!$param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $createMockCall = $this->createCreateMockCall($param, $param->type);
            if ($createMockCall !== null) {
                $assigns[] = $createMockCall;
            }
        }
        // remove all params
        $classMethod->params = [];
        $classMethod->stmts = \array_merge($assigns, (array) $classMethod->stmts);
    }
    private function processMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isName($methodCall->name, 'shouldBeCalled')) {
            if (!$methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $mockMethodName = $this->getName($methodCall->var->name);
            if ($mockMethodName === null) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $expectedArg = $methodCall->var->args[0]->value ?? null;
            $methodCall->var->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('expects');
            $thisOnceMethodCall = $this->createLocalMethodCall('atLeastOnce');
            $methodCall->var->args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($thisOnceMethodCall)];
            $methodCall->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('method');
            $methodCall->args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($mockMethodName))];
            if ($expectedArg !== null) {
                return $this->appendWithMethodCall($methodCall, $expectedArg);
            }
            return $methodCall;
        }
        return null;
    }
    /**
     * Variable or property fetch, based on number of present params in whole class
     */
    private function createCreateMockCall(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Name $name) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        /** @var Class_ $classLike */
        $classLike = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $classMocks = $this->phpSpecMockCollector->resolveClassMocksFromParam($classLike);
        $variable = $this->getName($param->var);
        $method = $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        $methodsWithWThisMock = $classMocks[$variable];
        // single use: "$mock = $this->createMock()"
        if (!$this->phpSpecMockCollector->isVariableMockInProperty($param->var)) {
            return $this->createNewMockVariableAssign($param, $name);
        }
        $reversedMethodsWithThisMock = \array_flip($methodsWithWThisMock);
        // first use of many: "$this->mock = $this->createMock()"
        if ($reversedMethodsWithThisMock[$method] === 0) {
            return $this->createPropertyFetchMockVariableAssign($param, $name);
        }
        return null;
    }
    private function appendWithMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $withMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall, 'with');
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            if ($this->isName($expr->class, '*Argument')) {
                if ($this->isName($expr->name, 'any')) {
                    // no added value having this method
                    return $methodCall;
                }
                if ($this->isName($expr->name, 'type')) {
                    $expr = $this->createIsTypeOrIsInstanceOf($expr);
                }
            }
        } else {
            $newExpr = $this->createLocalMethodCall('equalTo');
            $newExpr->args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr)];
            $expr = $newExpr;
        }
        $withMethodCall->args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr)];
        return $withMethodCall;
    }
    private function createNewMockVariableAssign(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Name $name) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $methodCall = $this->createLocalMethodCall('createMock');
        $methodCall->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch($name, 'class'));
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($param->var, $methodCall);
        $assignExpression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
        // add @var doc comment
        $varDoc = $this->createMockVarDoc($param, $name);
        $assignExpression->setDocComment(new \_PhpScopere8e811afab72\PhpParser\Comment\Doc($varDoc));
        return $assignExpression;
    }
    private function createPropertyFetchMockVariableAssign(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Name $name) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $variable = $this->getName($param->var);
        if ($variable === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $propertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $variable);
        $methodCall = $this->createLocalMethodCall('createMock');
        $methodCall->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch($name, 'class'));
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($propertyFetch, $methodCall);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
    private function createIsTypeOrIsInstanceOf(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $type = $this->getValue($staticCall->args[0]->value);
        $name = $this->typeAnalyzer->isPhpReservedType($type) ? 'isType' : 'isInstanceOf';
        return $this->createLocalMethodCall($name, $staticCall->args);
    }
    private function createMockVarDoc(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\Name $name) : string
    {
        $paramType = (string) ($name->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME) ?: $name);
        $variableName = $this->getName($param->var);
        if ($variableName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return \sprintf('/** @var %s|\\%s $%s */', $paramType, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\MockObject', $variableName);
    }
}
