<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Nette\NodeFactory\ParentGetterStmtsToExternalStmtsFactory $parentGetterStmtsToExternalStmtsFactory)
    {
        $this->parentGetterStmtsToExternalStmtsFactory = $parentGetterStmtsToExternalStmtsFactory;
    }
    /**
     * @param Node[] $getUserStmts
     */
    public function create(array $getUserStmts) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder(self::CHECK_REQUIREMENTS_METHOD_NAME);
        $methodBuilder->makePublic();
        $paramBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\ParamBuilder('element');
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->setReturnType('void');
        $parentStaticCall = $this->creatParentStaticCall();
        $newStmts = $this->parentGetterStmtsToExternalStmtsFactory->create($getUserStmts);
        $methodBuilder->addStmts($newStmts);
        $methodBuilder->addStmt($parentStaticCall);
        return $methodBuilder->getNode();
    }
    private function creatParentStaticCall() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall
    {
        $args = [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('element'))];
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('parent'), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier(self::CHECK_REQUIREMENTS_METHOD_NAME), $args);
    }
}
