<?php

declare (strict_types=1);
namespace Rector\Caching\Cache\Adapter;

use _PhpScoperfce0de0de1ce\Nette\Utils\Strings;
use Rector\Core\Configuration\Option;
use _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
    public function create() : \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\Adapter\FilesystemAdapter
    {
        return new \_PhpScoperfce0de0de1ce\Symfony\Component\Cache\Adapter\FilesystemAdapter(
            // unique per project
            \_PhpScoperfce0de0de1ce\Nette\Utils\Strings::webalize(\getcwd()),
            0,
            $this->parameterProvider->provideParameter(\Rector\Core\Configuration\Option::CACHE_DIR)
        );
    }
}
