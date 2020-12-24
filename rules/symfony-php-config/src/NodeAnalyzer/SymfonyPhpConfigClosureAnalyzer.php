<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SymfonyPhpConfig\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class SymfonyPhpConfigClosureAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPhpConfigClosure(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure $closure) : bool
    {
        if (\count((array) $closure->params) !== 1) {
            return \false;
        }
        $onlyParam = $closure->params[0];
        if ($onlyParam->type === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($onlyParam->type, '_PhpScoper0a6b37af0871\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator');
    }
}
