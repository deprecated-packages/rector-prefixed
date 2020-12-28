<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\PhpConfigPrinter\ValueObject;

final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE = 'RectorPrefix20201228\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\inline_service';
    /**
     * @var string
     */
    public const SERVICE = 'RectorPrefix20201228\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\service';
    /**
     * @var string
     */
    public const REF = 'RectorPrefix20201228\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ref';
    /**
     * @var string
     */
    public const EXPR = 'RectorPrefix20201228\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\expr';
}
