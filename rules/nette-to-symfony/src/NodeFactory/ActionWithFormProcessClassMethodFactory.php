<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Request;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Response;
final class ActionWithFormProcessClassMethodFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function create(string $formTypeClass) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $classMethod = $this->nodeFactory->createPublicMethod('actionSomeForm');
        $requestVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('request');
        $classMethod->params[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Param($requestVariable, null, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\_PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Request::class));
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified(\_PhpScoperb75b35f52b74\Symfony\Component\HttpFoundation\Response::class);
        $formVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('form');
        $assign = $this->createFormInstanceAssign($formTypeClass, $formVariable);
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
        $handleRequestMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($formVariable, 'handleRequest', [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($requestVariable)]);
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($handleRequestMethodCall);
        $booleanAnd = $this->createFormIsSuccessAndIsValid($formVariable);
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_($booleanAnd);
        return $classMethod;
    }
    private function createFormInstanceAssign(string $formTypeClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $classConstFetch = $this->nodeFactory->createClassConstReference($formTypeClass);
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($classConstFetch)];
        $createFormMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'createForm', $args);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($formVariable, $createFormMethodCall);
    }
    private function createFormIsSuccessAndIsValid(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $formVariable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd
    {
        $isSuccessMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($formVariable, 'isSuccess');
        $isValidMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($formVariable, 'isValid');
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd($isSuccessMethodCall, $isValidMethodCall);
    }
}
