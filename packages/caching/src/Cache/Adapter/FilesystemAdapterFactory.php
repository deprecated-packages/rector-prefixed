<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Caching\Cache\Adapter;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\_PhpScoper2a4e7ab1ecbc\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
