<?php

declare (strict_types=1);
namespace RectorPrefix20210118\Symplify\PhpConfigPrinter\PhpParser\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use RectorPrefix20210118\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210118\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use RectorPrefix20210118\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ConfiguratorClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createContainerClosureFromStmts(array $stmts) : \PhpParser\Node\Expr\Closure
    {
        $param = $this->createContainerConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    /**
     * @param Node[] $stmts
     */
    public function createRoutingClosureFromStmts(array $stmts) : \PhpParser\Node\Expr\Closure
    {
        $param = $this->createRoutingConfiguratorParam();
        return $this->createClosureFromParamAndStmts($param, $stmts);
    }
    private function createContainerConfiguratorParam() : \PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \PhpParser\Node\Expr\Variable(\RectorPrefix20210118\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        return new \PhpParser\Node\Param($containerConfiguratorVariable, null, new \PhpParser\Node\Name\FullyQualified(\RectorPrefix20210118\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class));
    }
    private function createRoutingConfiguratorParam() : \PhpParser\Node\Param
    {
        $containerConfiguratorVariable = new \PhpParser\Node\Expr\Variable(\RectorPrefix20210118\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        return new \PhpParser\Node\Param($containerConfiguratorVariable, null, new \PhpParser\Node\Name\FullyQualified(\RectorPrefix20210118\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator::class));
    }
    private function createClosureFromParamAndStmts(\PhpParser\Node\Param $param, array $stmts) : \PhpParser\Node\Expr\Closure
    {
        $closure = new \PhpParser\Node\Expr\Closure(['params' => [$param], 'stmts' => $stmts, 'static' => \true]);
        // is PHP 7.1? → add "void" return type
        if (\version_compare(\PHP_VERSION, '7.1.0') >= 0) {
            $closure->returnType = new \PhpParser\Node\Identifier('void');
        }
        return $closure;
    }
}
