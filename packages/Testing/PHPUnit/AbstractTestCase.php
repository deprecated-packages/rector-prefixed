<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit;

use PHPUnit\Framework\TestCase;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210504\Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array<string, RectorKernel>
     */
    private static $kernelsByHash = [];
    /**
     * @var ContainerInterface
     */
    private static $currentContainer;
    protected function boot() : void
    {
        $this->bootFromConfigFileInfos([]);
    }
    /**
     * @param SmartFileInfo[] $configFileInfos
     */
    protected function bootFromConfigFileInfos(array $configFileInfos) : void
    {
        $configsHash = $this->createConfigsHash($configFileInfos);
        if (isset(self::$kernelsByHash[$configsHash])) {
            $rectorKernel = self::$kernelsByHash[$configsHash];
            self::$currentContainer = $rectorKernel->getContainer();
        } else {
            $rectorKernel = new \Rector\Core\HttpKernel\RectorKernel('test_' . $configsHash, \true, $configFileInfos);
            $rectorKernel->boot();
            self::$kernelsByHash[$configsHash] = $rectorKernel;
            self::$currentContainer = $rectorKernel->getContainer();
        }
    }
    /**
     * Syntax-sugar to remove static
     *
     * @template T of object
     * @param class-string<T> $type
     * @return T
     */
    protected function getService(string $type) : object
    {
        if (self::$currentContainer === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException('First, create container with "bootWithConfigFileInfos([...])"');
        }
        return self::$currentContainer->get($type);
    }
    /**
     * @param SmartFileInfo[] $configFileInfos
     */
    private function createConfigsHash(array $configFileInfos) : string
    {
        $configHash = '';
        foreach ($configFileInfos as $configFileInfo) {
            $configHash .= \md5_file($configFileInfo->getRealPath());
        }
        return $configHash;
    }
}
