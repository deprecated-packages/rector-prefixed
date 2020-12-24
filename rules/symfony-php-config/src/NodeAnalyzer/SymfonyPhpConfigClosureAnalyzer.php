<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SymfonyPhpConfig\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class SymfonyPhpConfigClosureAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPhpConfigClosure(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure $closure) : bool
    {
        if (\count((array) $closure->params) !== 1) {
            return \false;
        }
        $onlyParam = $closure->params[0];
        if ($onlyParam->type === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($onlyParam->type, '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator');
    }
}
