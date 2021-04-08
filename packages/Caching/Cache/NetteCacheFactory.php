<?php

declare (strict_types=1);
namespace Rector\Caching\Cache;

use RectorPrefix20210408\Nette\Caching\Cache;
use RectorPrefix20210408\Nette\Caching\Storages\FileStorage;
use RectorPrefix20210408\Nette\Utils\Strings;
use Rector\Core\Configuration\Option;
use RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem;
final class NetteCacheFactory
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\RectorPrefix20210408\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->parameterProvider = $parameterProvider;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function create() : \RectorPrefix20210408\Nette\Caching\Cache
    {
        $cacheDirectory = $this->parameterProvider->provideStringParameter(\Rector\Core\Configuration\Option::CACHE_DIR);
        // ensure cache directory exists
        if (!$this->smartFileSystem->exists($cacheDirectory)) {
            $this->smartFileSystem->mkdir($cacheDirectory);
        }
        $fileStorage = new \RectorPrefix20210408\Nette\Caching\Storages\FileStorage($cacheDirectory);
        // namespace is unique per project
        $namespace = \RectorPrefix20210408\Nette\Utils\Strings::webalize(\getcwd());
        return new \RectorPrefix20210408\Nette\Caching\Cache($fileStorage, $namespace);
    }
}
