<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Nette\NodeFactory\ParentGetterStmtsToExternalStmtsFactory $parentGetterStmtsToExternalStmtsFactory)
    {
        $this->parentGetterStmtsToExternalStmtsFactory = $parentGetterStmtsToExternalStmtsFactory;
    }
    /**
     * @param Node[] $getUserStmts
     */
    public function create(array $getUserStmts) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder(self::CHECK_REQUIREMENTS_METHOD_NAME);
        $methodBuilder->makePublic();
        $paramBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder('element');
        $methodBuilder->addParam($paramBuilder);
        $methodBuilder->setReturnType('void');
        $parentStaticCall = $this->creatParentStaticCall();
        $newStmts = $this->parentGetterStmtsToExternalStmtsFactory->create($getUserStmts);
        $methodBuilder->addStmts($newStmts);
        $methodBuilder->addStmt($parentStaticCall);
        return $methodBuilder->getNode();
    }
    private function creatParentStaticCall() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall
    {
        $args = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('element'))];
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('parent'), new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier(self::CHECK_REQUIREMENTS_METHOD_NAME), $args);
    }
}
