<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SymfonyPhpConfig\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class SymfonyPhpConfigClosureAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isPhpConfigClosure(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure $closure) : bool
    {
        if (\count((array) $closure->params) !== 1) {
            return \false;
        }
        $onlyParam = $closure->params[0];
        if ($onlyParam->type === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($onlyParam->type, '_PhpScoperb75b35f52b74\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator');
    }
}
