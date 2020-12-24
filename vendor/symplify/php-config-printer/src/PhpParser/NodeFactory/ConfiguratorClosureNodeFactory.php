<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConfiguratorClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Node[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param($containerConfiguratorVariable, null, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class));
    }
    private function createRoutingConfiguratorParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param($containerConfiguratorVariable, null, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified(\_PhpScoper2a4e7ab1ecbc\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator::class));
    }
    private function createClosureFromParamAndStmts(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, array $stmts) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure
    {
        $closure = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        // is PHP 7.1? → add "void" return type
        if (\version_compare(\PHP_VERSION, '7.1.0') >= 0) {
            $closure->returnType = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('void');
        }
        return $closure;
    }
}
