<?php

declare (strict_types=1);
namespace Rector\Caching\Cache\Adapter;

use RectorPrefix20210308\Nette\Utils\Strings;
use Rector\Core\Configuration\Option;
use RectorPrefix20210308\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use RectorPrefix20210308\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FilesystemAdapterFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\RectorPrefix20210308\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function create() : \RectorPrefix20210308\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \RectorPrefix20210308\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \RectorPrefix20210308\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
