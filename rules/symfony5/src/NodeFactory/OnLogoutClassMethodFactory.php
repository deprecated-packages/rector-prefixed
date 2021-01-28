<?php

declare (strict_types=1);
namespace Rector\Symfony5\NodeFactory;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator;
use Rector\NodeNameResolver\NodeNameResolver;
final class OnLogoutClassMethodFactory
{
    /**
     * @var array<string, string>
     */
    private const PARAMETER_TO_GETTER_NAMES = ['request' => 'getRequest', 'response' => 'getResponse', 'token' => 'getToken'];
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    /**
     * @var ListeningClassMethodArgumentManipulator
     */
    private $listeningClassMethodArgumentManipulator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\NetteKdyby\NodeManipulator\ListeningClassMethodArgumentManipulator $listeningClassMethodArgumentManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeFactory = $nodeFactory;
        $this->phpVersionProvider = $phpVersionProvider;
        $this->listeningClassMethodArgumentManipulator = $listeningClassMethodArgumentManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createFromLogoutClassMethod(\PhpParser\Node\Stmt\ClassMethod $logoutClassMethod) : \PhpParser\Node\Stmt\ClassMethod
    {
        $classMethod = $this->nodeFactory->createPublicMethod('onLogout');
        $logoutEventVariable = new \PhpParser\Node\Expr\Variable('logoutEvent');
        $classMethod->params[] = $this->createLogoutEventParam($logoutEventVariable);
        $usedParams = [];
        foreach ($logoutClassMethod->params as $oldParam) {
            if (!$this->listeningClassMethodArgumentManipulator->isParamUsedInClassMethodBody($logoutClassMethod, $oldParam)) {
                continue;
            }
            $usedParams[] = $oldParam;
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::VOID_TYPE)) {
            $classMethod->returnType = new \PhpParser\Node\Identifier('void');
        }
        $assignStmts = $this->createAssignStmts($usedParams, $logoutEventVariable);
        $classMethod->stmts = \array_merge($assignStmts, (array) $logoutClassMethod->stmts);
        return $classMethod;
    }
    private function createLogoutEventParam(\PhpParser\Node\Expr\Variable $logoutEventVariable) : \PhpParser\Node\Param
    {
        $param = new \PhpParser\Node\Param($logoutEventVariable);
        $param->type = new \PhpParser\Node\Name\FullyQualified('Symfony\\Component\\Security\\Http\\Event\\LogoutEvent');
        return $param;
    }
    /**
     * @param Param[] $params
     * @return Expression[]
     */
    private function createAssignStmts(array $params, \PhpParser\Node\Expr\Variable $logoutEventVariable) : array
    {
        $assignStmts = [];
        foreach ($params as $param) {
            foreach (self::PARAMETER_TO_GETTER_NAMES as $parameterName => $getterName) {
                if (!$this->nodeNameResolver->isName($param, $parameterName)) {
                    continue;
                }
                $assign = new \PhpParser\Node\Expr\Assign($param->var, new \PhpParser\Node\Expr\MethodCall($logoutEventVariable, $getterName));
                $assignStmts[] = new \PhpParser\Node\Stmt\Expression($assign);
            }
        }
        return $assignStmts;
    }
}
