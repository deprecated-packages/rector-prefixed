<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Nette\NodeFactory\ParentGetterStmtsToExternalStmtsFactory $parentGetterStmtsToExternalStmtsFactory)
    {
        $this->parentGetterStmtsToExternalStmtsFactory = $parentGetterStmtsToExternalStmtsFactory;
    }
    /**
     * @param Node[] $getUserStmts
     */
    public function create(array $getUserStmts) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder(self::CHECK_REQUIREMENTS_METHOD_NAME);
        $methodBuilder->makePublic();
        $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder('element');
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->setReturnType('void');
        $parentStaticCall = $this->creatParentStaticCall();
        $newStmts = $this->parentGetterStmtsToExternalStmtsFactory->create($getUserStmts);
        $methodBuilder->addStmts($newStmts);
        $methodBuilder->addStmt($parentStaticCall);
        return $methodBuilder->getNode();
    }
    private function creatParentStaticCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall
    {
        $args = [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('element'))];
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('parent'), new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier(self::CHECK_REQUIREMENTS_METHOD_NAME), $args);
    }
}
