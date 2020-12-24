<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request;
use _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Response;
final class ActionWithFormProcessClassMethodFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function create(string $formTypeClass) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $classMethod = $this->nodeFactory->createPublicMethod('actionSomeForm');
        $requestVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('request');
        $classMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param($requestVariable, null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request::class));
        $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Response::class);
        $formVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('form');
        $assign = $this->createFormInstanceAssign($formTypeClass, $formVariable);
        $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
        $handleRequestMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($formVariable, 'handleRequest', [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($requestVariable)]);
        $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($handleRequestMethodCall);
        $booleanAnd = $this->createFormIsSuccessAndIsValid($formVariable);
        $classMethod->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_($booleanAnd);
        return $classMethod;
    }
    private function createFormInstanceAssign(string $formTypeClass, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        $classConstFetch = $this->nodeFactory->createClassConstReference($formTypeClass);
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($classConstFetch)];
        $createFormMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), 'createForm', $args);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($formVariable, $createFormMethodCall);
    }
    private function createFormIsSuccessAndIsValid(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $isSuccessMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($formVariable, 'isSuccess');
        $isValidMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($formVariable, 'isValid');
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd($isSuccessMethodCall, $isValidMethodCall);
    }
}
