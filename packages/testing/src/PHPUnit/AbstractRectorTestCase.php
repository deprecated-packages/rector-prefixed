<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit;

use Iterator;
use RectorPrefix20210302\Nette\Utils\Strings;
use PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20210302\PHPUnit\Framework\ExpectationFailedException;
use RectorPrefix20210302\Psr\Container\ContainerInterface;
use Rector\Core\Application\FileProcessor;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Bootstrap\RectorConfigsResolver;
use Rector\Core\Configuration\Option;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\NonPhpFile\NonPhpFileProcessor;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\Stubs\StubLoader;
use Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider;
use Rector\Testing\Application\EnabledRectorClassProvider;
use Rector\Testing\Configuration\AllRectorConfigFactory;
use Rector\Testing\Contract\RunnableInterface;
use Rector\Testing\Guard\FixtureGuard;
use Rector\Testing\PHPUnit\Behavior\MovingFilesTrait;
use RectorPrefix20210302\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210302\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater;
use RectorPrefix20210302\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210302\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210302\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractRectorTestCase extends \RectorPrefix20210302\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    use MovingFilesTrait;
    /**
     * @var FileProcessor
     */
    protected $fileProcessor;
    /**
     * @var SmartFileSystem
     */
    protected static $smartFileSystem;
    /**
     * @var NonPhpFileProcessor
     */
    protected $nonPhpFileProcessor;
    /**
     * @var ParameterProvider
     */
    protected $parameterProvider;
    /**
     * @var FixtureGuard
     */
    protected static $fixtureGuard;
    /**
     * @var RemovedAndAddedFilesCollector
     */
    protected $removedAndAddedFilesCollector;
    /**
     * @var SmartFileInfo
     */
    protected $originalTempFileInfo;
    /**
     * @var ContainerInterface|null
     */
    protected static $allRectorContainer;
    /**
     * @var bool
     */
    private static $isInitialized = \false;
    /**
     * @var RunnableRectorFactory
     */
    private static $runnableRectorFactory;
    /**
     * @var RectorConfigsResolver
     */
    private static $rectorConfigsResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    protected function setUp() : void
    {
        $this->initializeDependencies();
        if ($this->provideConfigFilePath() !== '') {
            $configFileInfo = new \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo($this->provideConfigFilePath());
            $configFileInfos = self::$rectorConfigsResolver->resolveFromConfigFileInfo($configFileInfo);
            $this->bootKernelWithConfigsAndStaticCache(\Rector\Core\HttpKernel\RectorKernel::class, $configFileInfos);
            /** @var EnabledRectorClassProvider $enabledRectorsProvider */
            $enabledRectorsProvider = $this->getService(\Rector\Testing\Application\EnabledRectorClassProvider::class);
            $enabledRectorsProvider->reset();
        } else {
            // prepare container with all rectors
            // cache only rector tests - defined in phpunit.xml
            $this->createRectorRepositoryContainer();
            /** @var EnabledRectorClassProvider $enabledRectorsProvider */
            $enabledRectorsProvider = $this->getService(\Rector\Testing\Application\EnabledRectorClassProvider::class);
            $enabledRectorsProvider->setEnabledRectorClass($this->getRectorClass());
        }
        $this->fileProcessor = $this->getService(\Rector\Core\Application\FileProcessor::class);
        $this->nonPhpFileProcessor = $this->getService(\Rector\Core\NonPhpFile\NonPhpFileProcessor::class);
        $this->parameterProvider = $this->getService(\RectorPrefix20210302\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
        $this->betterStandardPrinter = $this->getService(\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
        $this->removedAndAddedFilesCollector = $this->getService(\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector::class);
        $this->removedAndAddedFilesCollector->reset();
    }
    /**
     * @return class-string<RectorInterface>
     */
    protected function getRectorClass() : string
    {
        // can be implemented
        return '';
    }
    protected function provideConfigFilePath() : string
    {
        // can be implemented
        return '';
    }
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        return \RectorPrefix20210302\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectory($directory, $suffix);
    }
    /**
     * @param SmartFileInfo[] $extraFileInfos
     */
    protected function doTestFileInfo(\RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, array $extraFileInfos = []) : void
    {
        self::$fixtureGuard->ensureFileInfoHasDifferentBeforeAndAfterContent($fixtureFileInfo);
        $inputFileInfoAndExpectedFileInfo = \RectorPrefix20210302\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo, \false);
        $inputFileInfo = $inputFileInfoAndExpectedFileInfo->getInputFileInfo();
        // needed for PHPStan, because the analyzed file is just create in /temp
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $this->getService(\PHPStan\Analyser\NodeScopeResolver::class);
        $nodeScopeResolver->setAnalysedFiles([$inputFileInfo->getRealPath()]);
        /** @var DynamicSourceLocatorProvider $dynamicDirectoryLocatorProvider */
        $dynamicDirectoryLocatorProvider = $this->getService(\Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider::class);
        $dynamicDirectoryLocatorProvider->setFileInfo($inputFileInfo);
        $expectedFileInfo = $inputFileInfoAndExpectedFileInfo->getExpectedFileInfo();
        $this->doTestFileMatchesExpectedContent($inputFileInfo, $expectedFileInfo, $fixtureFileInfo, $extraFileInfos);
        $this->originalTempFileInfo = $inputFileInfo;
        $this->processRunnableTest($inputFileInfo, $expectedFileInfo);
    }
    protected function doTestExtraFile(string $expectedExtraFileName, string $expectedExtraContentFilePath) : void
    {
        $addedFilesWithContents = $this->removedAndAddedFilesCollector->getAddedFilesWithContent();
        foreach ($addedFilesWithContents as $addedFilesWithContent) {
            if (!\RectorPrefix20210302\Nette\Utils\Strings::endsWith($addedFilesWithContent->getFilePath(), $expectedExtraFileName)) {
                continue;
            }
            $this->assertStringEqualsFile($expectedExtraContentFilePath, $addedFilesWithContent->getFileContent());
            return;
        }
        $addedFilesWithNodes = $this->removedAndAddedFilesCollector->getAddedFilesWithNodes();
        foreach ($addedFilesWithNodes as $addedFileWithNodes) {
            if (!\RectorPrefix20210302\Nette\Utils\Strings::endsWith($addedFileWithNodes->getFilePath(), $expectedExtraFileName)) {
                continue;
            }
            $printedFileContent = $this->betterStandardPrinter->prettyPrintFile($addedFileWithNodes->getNodes());
            $this->assertStringEqualsFile($expectedExtraContentFilePath, $printedFileContent);
            return;
        }
        $movedFilesWithContent = $this->removedAndAddedFilesCollector->getMovedFileWithContent();
        foreach ($movedFilesWithContent as $movedFileWithContent) {
            if (!\RectorPrefix20210302\Nette\Utils\Strings::endsWith($movedFileWithContent->getNewPathname(), $expectedExtraFileName)) {
                continue;
            }
            $this->assertStringEqualsFile($expectedExtraContentFilePath, $movedFileWithContent->getFileContent());
            return;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
    protected function getFixtureTempDirectory() : string
    {
        return \sys_get_temp_dir() . '/_temp_fixture_easy_testing';
    }
    protected function assertOriginalAndFixedFileResultEquals(\RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        $inputRunnable = self::$runnableRectorFactory->createRunnableClass($originalFileInfo);
        $expectedRunnable = self::$runnableRectorFactory->createRunnableClass($expectedFileInfo);
        $inputResult = $inputRunnable->run();
        $expectedResult = $expectedRunnable->run();
        $this->assertSame($expectedResult, $inputResult);
    }
    private function createRectorRepositoryContainer() : void
    {
        if (self::$allRectorContainer === null) {
            $allRectorConfigFactory = new \Rector\Testing\Configuration\AllRectorConfigFactory();
            $configFilePath = $allRectorConfigFactory->create();
            $this->bootKernelWithConfigs(\Rector\Core\HttpKernel\RectorKernel::class, [$configFilePath]);
            self::$allRectorContainer = self::$container;
            return;
        }
        // load from cache
        self::$container = self::$allRectorContainer;
    }
    /**
     * @param SmartFileInfo[] $extraFileInfos
     */
    private function doTestFileMatchesExpectedContent(\RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo, \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, array $extraFileInfos = []) : void
    {
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::SOURCE, [$originalFileInfo->getRealPath()]);
        if (!\RectorPrefix20210302\Nette\Utils\Strings::endsWith($originalFileInfo->getFilename(), '.blade.php') && \in_array($originalFileInfo->getSuffix(), ['php', 'phpt'], \true)) {
            if ($extraFileInfos === []) {
                $this->fileProcessor->parseFileInfoToLocalCache($originalFileInfo);
                $this->fileProcessor->refactor($originalFileInfo);
                $this->fileProcessor->postFileRefactor($originalFileInfo);
            } else {
                $fileInfosToProcess = \array_merge([$originalFileInfo], $extraFileInfos);
                // life-cycle trio :)
                foreach ($fileInfosToProcess as $fileInfoToProcess) {
                    $this->fileProcessor->parseFileInfoToLocalCache($fileInfoToProcess);
                }
                foreach ($fileInfosToProcess as $fileInfoToProcess) {
                    $this->fileProcessor->refactor($fileInfoToProcess);
                }
                foreach ($fileInfosToProcess as $fileInfoToProcess) {
                    $this->fileProcessor->postFileRefactor($fileInfoToProcess);
                }
            }
            // mimic post-rectors
            $changedContent = $this->fileProcessor->printToString($originalFileInfo);
        } elseif (\RectorPrefix20210302\Nette\Utils\Strings::match($originalFileInfo->getFilename(), \Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern())) {
            $changedContent = $this->nonPhpFileProcessor->processFileInfo($originalFileInfo);
        } else {
            $message = \sprintf('Suffix "%s" is not supported yet', $originalFileInfo->getSuffix());
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $relativeFilePathFromCwd = $fixtureFileInfo->getRelativeFilePathFromCwd();
        try {
            $this->assertStringEqualsFile($expectedFileInfo->getRealPath(), $changedContent, $relativeFilePathFromCwd);
        } catch (\RectorPrefix20210302\PHPUnit\Framework\ExpectationFailedException $expectationFailedException) {
            \RectorPrefix20210302\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater::updateFixtureContent($originalFileInfo, $changedContent, $fixtureFileInfo);
            $contents = $expectedFileInfo->getContents();
            // make sure we don't get a diff in which every line is different (because of differences in EOL)
            $contents = $this->normalizeNewlines($contents);
            // if not exact match, check the regex version (useful for generated hashes/uuids in the code)
            $this->assertStringMatchesFormat($contents, $changedContent, $relativeFilePathFromCwd);
        }
    }
    private function normalizeNewlines(string $string) : string
    {
        return \RectorPrefix20210302\Nette\Utils\Strings::replace($string, '#\\r\\n|\\r|\\n#', "\n");
    }
    /**
     * Static to avoid reboot on each data fixture
     */
    private function initializeDependencies() : void
    {
        if (self::$isInitialized) {
            return;
        }
        self::$runnableRectorFactory = new \Rector\Testing\PHPUnit\RunnableRectorFactory();
        self::$smartFileSystem = new \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileSystem();
        self::$fixtureGuard = new \Rector\Testing\Guard\FixtureGuard();
        self::$rectorConfigsResolver = new \Rector\Core\Bootstrap\RectorConfigsResolver();
        // load stubs
        $stubLoader = new \Rector\Core\Stubs\StubLoader();
        $stubLoader->loadStubs();
        self::$isInitialized = \true;
    }
    private function processRunnableTest(\RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \RectorPrefix20210302\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo) : void
    {
        // runnable?
        if (!\file_exists($inputFileInfo->getPathname())) {
            return;
        }
        if (!\RectorPrefix20210302\Nette\Utils\Strings::contains($inputFileInfo->getContents(), \Rector\Testing\Contract\RunnableInterface::class)) {
            return;
        }
        $this->assertOriginalAndFixedFileResultEquals($inputFileInfo, $expectedFileInfo);
    }
}
