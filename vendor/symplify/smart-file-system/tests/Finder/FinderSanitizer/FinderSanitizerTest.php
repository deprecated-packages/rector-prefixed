<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Tests\Finder\FinderSanitizer;

use _PhpScoperb75b35f52b74\Nette\Utils\Finder as NetteFinder;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use SplFileInfo;
use _PhpScoperb75b35f52b74\Symfony\Component\Finder\Finder as SymfonyFinder;
use _PhpScoperb75b35f52b74\Symfony\Component\Finder\SplFileInfo as SymfonySplFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class FinderSanitizerTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    protected function setUp() : void
    {
        $this->finderSanitizer = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\Finder\FinderSanitizer();
    }
    public function testValidTypes() : void
    {
        $files = [new \SplFileInfo(__DIR__ . '/Source/MissingFile.php')];
        $this->assertCount(0, $this->finderSanitizer->sanitize($files));
    }
    public function testSymfonyFinder() : void
    {
        $symfonyFinder = \_PhpScoperb75b35f52b74\Symfony\Component\Finder\Finder::create()->files()->in(__DIR__ . '/Source');
        $fileInfos = \iterator_to_array($symfonyFinder->getIterator());
        $this->assertCount(2, $fileInfos);
        $files = $this->finderSanitizer->sanitize($symfonyFinder);
        $this->assertCount(2, $files);
        $this->assertFilesEqualFixtureFiles($files[0], $files[1]);
    }
    public function testNetteFinder() : void
    {
        $netteFinder = \_PhpScoperb75b35f52b74\Nette\Utils\Finder::findFiles('*')->from(__DIR__ . '/Source');
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
    private function assertFilesEqualFixtureFiles(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $firstSmartFileInfo, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $secondSmartFileInfo) : void
    {
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($firstSmartFileInfo);
        $this->assertFileIsFromFixtureDirAndHasCorrectClass($secondSmartFileInfo);
        // order agnostic file check
        $this->assertTrue(\_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php') && \_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') || \_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($firstSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/EmptyFile.php') && \_PhpScoperb75b35f52b74\Nette\Utils\Strings::endsWith($secondSmartFileInfo->getRelativeFilePath(), 'NestedDirectory/FileWithClass.php'));
    }
    private function assertFileIsFromFixtureDirAndHasCorrectClass(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : void
    {
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\Symfony\Component\Finder\SplFileInfo::class, $smartFileInfo);
        $this->assertStringEndsWith('NestedDirectory', $smartFileInfo->getRelativeDirectoryPath());
    }
}
