<?php

declare (strict_types=1);
namespace Rector\Caching\Cache\Adapter;

use _PhpScoper5b8c9e9ebd21\Nette\Utils\Strings;
use Rector\Core\Configuration\Option;
use _PhpScoper5b8c9e9ebd21\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \_PhpScoper5b8c9e9ebd21\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoper5b8c9e9ebd21\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoper5b8c9e9ebd21\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
