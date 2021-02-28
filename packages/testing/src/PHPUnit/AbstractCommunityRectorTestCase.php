<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit;

use Iterator;
use PHPStan\Analyser\NodeScopeResolver;
use Rector\Core\Application\FileProcessor;
use Rector\Core\Bootstrap\RectorConfigsResolver;
use Rector\Core\Configuration\Option;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Testing\Contract\CommunityRectorTestCaseInterface;
use Rector\Testing\Guard\FixtureGuard;
use RectorPrefix20210228\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210228\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater;
use RectorPrefix20210228\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210228\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210228\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractCommunityRectorTestCase extends \RectorPrefix20210228\Symplify\PackageBuilder\Testing\AbstractKernelTestCase implements \Rector\Testing\Contract\CommunityRectorTestCaseInterface
{
    /**
     * @var FileProcessor
     */
    protected $fileProcessor;
    /**
     * @var ParameterProvider
     */
    protected $parameterProvider;
    /**
     * @var bool
     */
    private static $isInitialized = \false;
    /**
     * @var FixtureGuard
     */
    private static $fixtureGuard;
    /**
     * @var RectorConfigsResolver
     */
    private static $rectorConfigsResolver;
    protected function setUp() : void
    {
        $this->initializeDependencies();
        $smartFileInfo = new \RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo($this->provideConfigFilePath());
        $configFileInfos = self::$rectorConfigsResolver->resolveFromConfigFileInfo($smartFileInfo);
        $this->bootKernelWithConfigs(\Rector\Core\HttpKernel\RectorKernel::class, $configFileInfos);
        $this->fileProcessor = $this->getService(\Rector\Core\Application\FileProcessor::class);
        $this->parameterProvider = $this->getService(\RectorPrefix20210228\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
    }
    protected function doTestFileInfo(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, bool $shouldAutoload = \true) : void
    {
        self::$fixtureGuard->ensureFileInfoHasDifferentBeforeAndAfterContent($fixtureFileInfo);
        $inputFileInfoAndExpectedFileInfo = \RectorPrefix20210228\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, $shouldAutoload);
        $inputFileInfo = $inputFileInfoAndExpectedFileInfo->getInputFileInfo();
        // needed for PHPStan, because the analyzed file is just create in /temp
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $this->getService(\PHPStan\Analyser\NodeScopeResolver::class);
        $nodeScopeResolver->setAnalysedFiles([$inputFileInfo->getRealPath()]);
        $expectedFileInfo = $inputFileInfoAndExpectedFileInfo->getExpectedFileInfo();
        $this->doTestFileMatchesExpectedContent($inputFileInfo, $expectedFileInfo, $fixtureFileInfo);
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        return \RectorPrefix20210228\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    private function doTestFileMatchesExpectedContent(\RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo, \RectorPrefix20210228\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::SOURCE, [$originalFileInfo->getRealPath()]);
        $this->fileProcessor->parseFileInfoToLocalCache($originalFileInfo);
        $this->fileProcessor->refactor($originalFileInfo);
        $this->fileProcessor->postFileRefactor($originalFileInfo);
        // mimic post-rectors
        $changedContent = $this->fileProcessor->printToString($originalFileInfo);
        $relativeFilePathFromCwd = $fixtureFileInfo->getRelativeFilePathFromCwd();
        if (\getenv('UPDATE_TESTS') || \getenv('UT')) {
            \RectorPrefix20210228\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater::updateFixtureContent($originalFileInfo, $changedContent, $fixtureFileInfo);
        }
        $this->assertStringEqualsFile($expectedFileInfo->getRealPath(), $changedContent, $relativeFilePathFromCwd);
    }
    private function initializeDependencies() : void
    {
        if (self::$isInitialized) {
            return;
        }
        self::$fixtureGuard = new \Rector\Testing\Guard\FixtureGuard();
        self::$rectorConfigsResolver = new \Rector\Core\Bootstrap\RectorConfigsResolver();
        self::$isInitialized = \true;
    }
}
