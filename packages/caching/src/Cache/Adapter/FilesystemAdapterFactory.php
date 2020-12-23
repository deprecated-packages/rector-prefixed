<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Caching\Cache\Adapter;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option;
use _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoper0a2ac50786fa\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\_PhpScoper0a2ac50786fa\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
