<?php

declare (strict_types=1);
namespace Rector\Testing\PHPUnit;

use Iterator;
use RectorPrefix20210412\Nette\Utils\Strings;
use PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20210412\PHPUnit\Framework\ExpectationFailedException;
use RectorPrefix20210412\Psr\Container\ContainerInterface;
use Rector\Core\Application\ApplicationFileProcessor;
use Rector\Core\Application\FileProcessor;
use Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use Rector\Core\Bootstrap\RectorConfigsResolver;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Configuration\Option;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\NonPhpFile\NonPhpFileProcessor;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\ValueObject\Application\File;
use Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider;
use Rector\Testing\Contract\RectorTestInterface;
use Rector\Testing\PHPUnit\Behavior\MovingFilesTrait;
use RectorPrefix20210412\Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use RectorPrefix20210412\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater;
use RectorPrefix20210412\Symplify\EasyTesting\StaticFixtureSplitter;
use RectorPrefix20210412\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210412\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo;
abstract class AbstractRectorTestCase extends \RectorPrefix20210412\Symplify\PackageBuilder\Testing\AbstractKernelTestCase implements \Rector\Testing\Contract\RectorTestInterface
{
    use MovingFilesTrait;
    /**
     * @var FileProcessor
     */
    protected $fileProcessor;
    /**
     * @var NonPhpFileProcessor
     */
    protected $nonPhpFileProcessor;
    /**
     * @var ParameterProvider
     */
    protected $parameterProvider;
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
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var DynamicSourceLocatorProvider
     */
    private $dynamicSourceLocatorProvider;
    /**
     * @var ApplicationFileProcessor
     */
    private $applicationFileProcessor;
    protected function setUp() : void
    {
        // speed up
        @\ini_set('memory_limit', '-1');
        $configFileInfo = new \RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo($this->provideConfigFilePath());
        $rectorConfigsResolver = new \Rector\Core\Bootstrap\RectorConfigsResolver();
        $configFileInfos = $rectorConfigsResolver->resolveFromConfigFileInfo($configFileInfo);
        $this->bootKernelWithConfigsAndStaticCache(\Rector\Core\HttpKernel\RectorKernel::class, $configFileInfos);
        $this->fileProcessor = $this->getService(\Rector\Core\Application\FileProcessor::class);
        $this->nonPhpFileProcessor = $this->getService(\Rector\Core\NonPhpFile\NonPhpFileProcessor::class);
        $this->applicationFileProcessor = $this->getService(\Rector\Core\Application\ApplicationFileProcessor::class);
        $this->parameterProvider = $this->getService(\RectorPrefix20210412\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
        $this->betterStandardPrinter = $this->getService(\Rector\Core\PhpParser\Printer\BetterStandardPrinter::class);
        $this->dynamicSourceLocatorProvider = $this->getService(\Rector\NodeTypeResolver\Reflection\BetterReflection\SourceLocatorProvider\DynamicSourceLocatorProvider::class);
        $this->removedAndAddedFilesCollector = $this->getService(\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector::class);
        $this->removedAndAddedFilesCollector->reset();
        /** @var Configuration $configuration */
        $configuration = $this->getService(\Rector\Core\Configuration\Configuration::class);
        $configuration->setIsDryRun(\true);
    }
    public function provideConfigFilePath() : string
    {
        // must be implemented
        return '';
    }
    /**
     * @return Iterator<SmartFileInfo>
     */
    protected function yieldFilesFromDirectory(string $directory, string $suffix = '*.php.inc') : \Iterator
    {
        return \RectorPrefix20210412\Symplify\EasyTesting\DataProvider\StaticFixtureFinder::yieldDirectoryExclusively($directory, $suffix);
    }
    protected function doTestFileInfo(\RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $inputFileInfoAndExpectedFileInfo = \RectorPrefix20210412\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpectedFileInfos($fixtureFileInfo);
        $inputFileInfo = $inputFileInfoAndExpectedFileInfo->getInputFileInfo();
        $expectedFileInfo = $inputFileInfoAndExpectedFileInfo->getExpectedFileInfo();
        $this->doTestFileMatchesExpectedContent($inputFileInfo, $expectedFileInfo, $fixtureFileInfo);
        $this->originalTempFileInfo = $inputFileInfo;
    }
    protected function doTestExtraFile(string $expectedExtraFileName, string $expectedExtraContentFilePath) : void
    {
        $addedFilesWithContents = $this->removedAndAddedFilesCollector->getAddedFilesWithContent();
        foreach ($addedFilesWithContents as $addedFileWithContent) {
            if (!\RectorPrefix20210412\Nette\Utils\Strings::endsWith($addedFileWithContent->getFilePath(), $expectedExtraFileName)) {
                continue;
            }
            $this->assertStringEqualsFile($expectedExtraContentFilePath, $addedFileWithContent->getFileContent());
            return;
        }
        $addedFilesWithNodes = $this->removedAndAddedFilesCollector->getAddedFilesWithNodes();
        foreach ($addedFilesWithNodes as $addedFileWithNode) {
            if (!\RectorPrefix20210412\Nette\Utils\Strings::endsWith($addedFileWithNode->getFilePath(), $expectedExtraFileName)) {
                continue;
            }
            $printedFileContent = $this->betterStandardPrinter->prettyPrintFile($addedFileWithNode->getNodes());
            $this->assertStringEqualsFile($expectedExtraContentFilePath, $printedFileContent);
            return;
        }
        $movedFilesWithContent = $this->removedAndAddedFilesCollector->getMovedFileWithContent();
        foreach ($movedFilesWithContent as $movedFileWithContent) {
            if (!\RectorPrefix20210412\Nette\Utils\Strings::endsWith($movedFileWithContent->getNewPathname(), $expectedExtraFileName)) {
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
    private function doTestFileMatchesExpectedContent(\RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo, \RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $this->parameterProvider->changeParameter(\Rector\Core\Configuration\Option::SOURCE, [$originalFileInfo->getRealPath()]);
        $changedContent = $this->processFileInfo($originalFileInfo);
        // file is removed, we cannot compare it
        if ($this->removedAndAddedFilesCollector->isFileRemoved($originalFileInfo)) {
            return;
        }
        $relativeFilePathFromCwd = $fixtureFileInfo->getRelativeFilePathFromCwd();
        try {
            $this->assertStringEqualsFile($expectedFileInfo->getRealPath(), $changedContent, $relativeFilePathFromCwd);
        } catch (\RectorPrefix20210412\PHPUnit\Framework\ExpectationFailedException $expectationFailedException) {
            \RectorPrefix20210412\Symplify\EasyTesting\DataProvider\StaticFixtureUpdater::updateFixtureContent($originalFileInfo, $changedContent, $fixtureFileInfo);
            $contents = $expectedFileInfo->getContents();
            // make sure we don't get a diff in which every line is different (because of differences in EOL)
            $contents = $this->normalizeNewlines($contents);
            // if not exact match, check the regex version (useful for generated hashes/uuids in the code)
            $this->assertStringMatchesFormat($contents, $changedContent, $relativeFilePathFromCwd);
        }
    }
    private function normalizeNewlines(string $string) : string
    {
        return \RectorPrefix20210412\Nette\Utils\Strings::replace($string, '#\\r\\n|\\r|\\n#', "\n");
    }
    private function processFileInfo(\RectorPrefix20210412\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : string
    {
        $this->dynamicSourceLocatorProvider->setFileInfo($fileInfo);
        // needed for PHPStan, because the analyzed file is just created in /temp - need for trait and similar deps
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $this->getService(\PHPStan\Analyser\NodeScopeResolver::class);
        $nodeScopeResolver->setAnalysedFiles([$fileInfo->getRealPath()]);
        $file = new \Rector\Core\ValueObject\Application\File($fileInfo, $fileInfo->getContents());
        $this->applicationFileProcessor->run([$file]);
        return $file->getFileContent();
    }
}
