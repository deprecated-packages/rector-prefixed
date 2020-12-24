<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder;
final class CheckRequirementsClassMethodFactory
{
    /**
     * @var string
     */
    private const CHECK_REQUIREMENTS_METHOD_NAME = 'checkRequirements';
    /**
     * @var ParentGetterStmtsToExternalStmtsFactory
     */
    private $parentGetterStmtsToExternalStmtsFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Nette\NodeFactory\ParentGetterStmtsToExternalStmtsFactory $parentGetterStmtsToExternalStmtsFactory)
    {
        $this->parentGetterStmtsToExternalStmtsFactory = $parentGetterStmtsToExternalStmtsFactory;
    }
    /**
     * @param Node[] $getUserStmts
     */
    public function create(array $getUserStmts) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder(self::CHECK_REQUIREMENTS_METHOD_NAME);
        $methodBuilder->makePublic();
        $paramBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder('element');
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->setReturnType('void');
        $parentStaticCall = $this->creatParentStaticCall();
        $newStmts = $this->parentGetterStmtsToExternalStmtsFactory->create($getUserStmts);
        $methodBuilder->addStmts($newStmts);
        $methodBuilder->addStmt($parentStaticCall);
        return $methodBuilder->getNode();
    }
    private function creatParentStaticCall() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall
    {
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('element'))];
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('parent'), new \_PhpScopere8e811afab72\PhpParser\Node\Identifier(self::CHECK_REQUIREMENTS_METHOD_NAME), $args);
    }
}
