<?php

declare (strict_types=1);
namespace RectorPrefix20210118\Symplify\PhpConfigPrinter\ValueObject;

final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE = 'RectorPrefix20210118\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\inline_service';
    /**
     * @var string
     */
    public const SERVICE = 'RectorPrefix20210118\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\service';
    /**
     * @var string
     */
    public const REF = 'RectorPrefix20210118\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ref';
    /**
     * @var string
     */
    public const EXPR = 'RectorPrefix20210118\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\expr';
}
