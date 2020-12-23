<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Request;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Response;
final class ActionWithFormProcessClassMethodFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function create(string $formTypeClass) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $classMethod = $this->nodeFactory->createPublicMethod('actionSomeForm');
        $requestVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('request');
        $classMethod->params[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Param($requestVariable, null, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\_PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Request::class));
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\_PhpScoper0a2ac50786fa\Symfony\Component\HttpFoundation\Response::class);
        $formVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('form');
        $assign = $this->createFormInstanceAssign($formTypeClass, $formVariable);
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($assign);
        $handleRequestMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($formVariable, 'handleRequest', [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($requestVariable)]);
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($handleRequestMethodCall);
        $booleanAnd = $this->createFormIsSuccessAndIsValid($formVariable);
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_($booleanAnd);
        return $classMethod;
    }
    private function createFormInstanceAssign(string $formTypeClass, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        $classConstFetch = $this->nodeFactory->createClassConstReference($formTypeClass);
        $args = [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($classConstFetch)];
        $createFormMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this'), 'createForm', $args);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($formVariable, $createFormMethodCall);
    }
    private function createFormIsSuccessAndIsValid(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $isSuccessMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($formVariable, 'isSuccess');
        $isValidMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($formVariable, 'isValid');
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanAnd($isSuccessMethodCall, $isValidMethodCall);
    }
}
