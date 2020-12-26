<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Composer;

use RectorPrefix2020DecSat\Composer\Autoload\ClassLoader;
use RectorPrefix2020DecSat\Nette\Utils\Strings;
use ReflectionClass;
/**
 * @see \Symplify\PackageBuilder\Tests\Composer\VendorDirProviderTest
 */
final class VendorDirProvider
{
    public function provide() : string
    {
        $rootFolder = \getenv('SystemDrive', \true) . \DIRECTORY_SEPARATOR;
        $path = __DIR__;
        while (!\RectorPrefix2020DecSat\Nette\Utils\Strings::endsWith($path, 'vendor') && $path !== $rootFolder) {
            $path = \dirname($path);
        }
        if ($path !== $rootFolder) {
            return $path;
        }
        return $this->reflectionFallback();
    }
    private function reflectionFallback() : string
    {
        $reflectionClass = new \ReflectionClass(\RectorPrefix2020DecSat\Composer\Autoload\ClassLoader::class);
        return \dirname($reflectionClass->getFileName(), 2);
    }
}
