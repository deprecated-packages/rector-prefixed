<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Caching\Cache\Adapter;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Core\Configuration\Option;
use _PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoper0a6b37af0871\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoper0a6b37af0871\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\_PhpScoper0a6b37af0871\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
