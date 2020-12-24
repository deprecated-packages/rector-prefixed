<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer;

use _PhpScopere8e811afab72\Nette\Utils\Finder as NetteFinder;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use SplFileInfo;
use _PhpScopere8e811afab72\Symfony\Component\Finder\Finder as SymfonyFinder;
use _PhpScopere8e811afab72\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class FinderSanitizerTest extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    protected function setUp() : void
    {
        $this->finderSanitizer = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\Finder\FinderSanitizer();
    }
    public function testValidTypes() : void
    {
        $files = [new \SplFileInfo(__DIR__ . '/Source/MissingFile.php')];
        $this->assertCount(0, $this->finderSanitizer->sanitize($files));
    }
    public function testSymfonyFinder() : void
    {
        $symfonyFinder = \_PhpScopere8e811afab72\Symfony\Component\Finder\Finder::create()->files()->in(__DIR__ . '/Source');
        $fileInfos = \iterator_to_array($symfonyFinder->getIterator());
        $this->assertCount(2, $fileInfos);
        $files = $this->finderSanitizer->sanitize($symfonyFinder);
        $this->assertCount(2, $files);
        $this->assertFilesEqualFixtureFiles($files[0], $files[1]);
    }
    public function testNetteFinder() : void
    {
        $netteFinder = \_PhpScopere8e811afab72\Nette\Utils\Finder::findFiles('*')->from(__DIR__ . '/Source');
        $fileInfos = \iterator_to_array($netteFinder->getIterator());
        $this->assertCount(2, $fileInfos);
        $files = $this->finderSanitizer->sanitize($netteFinder);
        $this->assertCount(2, $files);
        $this->assertFilesEqualFixtureFiles($files[0], $files[1]);
    }
    /**
     * On different OS the order of the two files can differ, only symfony finder would have a sort function, nette
     * finder does not. so we test if the correct files are there but ignore the order.
     */
    private function assertFilesEqualFixtureFiles(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $firstSmartFileInfo, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $secondSmartFileInfo) : void
    {
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($firstSmartFileInfo);
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($secondSmartFileInfo);
        // order agnostic file check
        $this->assertTrue(\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php') && \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') || \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') && \_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php'));
    }
    private function assertFileIsFromFixtureDirAndHasCorrectClass(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->assertInstanceOf(\_PhpScopere8e811afab72\Symfony\Component\Finder\SplFileInfo::class, $smartFileInfo);
        $this->assertStringEndsWith('NestedDirectory', $smartFileInfo->getRelativeDirectoryPath());
    }
}
