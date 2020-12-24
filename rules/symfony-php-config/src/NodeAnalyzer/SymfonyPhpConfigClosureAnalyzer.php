<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SymfonyPhpConfig\NodeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
final class SymfonyPhpConfigClosureAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPhpConfigClosure(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure $closure) : bool
    {
        if (\count((array) $closure->params) !== 1) {
            return \false;
        }
        $onlyParam = $closure->params[0];
        if ($onlyParam->type === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($onlyParam->type, '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator');
    }
}
