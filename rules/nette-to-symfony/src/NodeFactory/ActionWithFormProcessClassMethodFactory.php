<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Request;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response;
final class ActionWithFormProcessClassMethodFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function create(string $formTypeClass) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $classMethod = $this->nodeFactory->createPublicMethod('actionSomeForm');
        $requestVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('request');
        $classMethod->params[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param($requestVariable, null, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Request::class));
        $classMethod->returnType = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\HttpFoundation\Response::class);
        $formVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('form');
        $assign = $this->createFormInstanceAssign($formTypeClass, $formVariable);
        $classMethod->stmts[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($assign);
        $handleRequestMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($formVariable, 'handleRequest', [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($requestVariable)]);
        $classMethod->stmts[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression($handleRequestMethodCall);
        $booleanAnd = $this->createFormIsSuccessAndIsValid($formVariable);
        $classMethod->stmts[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_($booleanAnd);
        return $classMethod;
    }
    private function createFormInstanceAssign(string $formTypeClass, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        $classConstFetch = $this->nodeFactory->createClassConstReference($formTypeClass);
        $args = [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($classConstFetch)];
        $createFormMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('this'), 'createForm', $args);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($formVariable, $createFormMethodCall);
    }
    private function createFormIsSuccessAndIsValid(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $isSuccessMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($formVariable, 'isSuccess');
        $isValidMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($formVariable, 'isValid');
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanAnd($isSuccessMethodCall, $isValidMethodCall);
    }
}
