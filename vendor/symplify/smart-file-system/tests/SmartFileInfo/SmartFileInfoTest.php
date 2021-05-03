<?php

declare (strict_types=1);
namespace RectorPrefix20210503\Symplify\SmartFileSystem\Tests\SmartFileInfo;

use RectorPrefix20210503\PHPUnit\Framework\TestCase;
use RectorPrefix20210503\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException;
use RectorPrefix20210503\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use Symplify\SmartFileSystem\SmartFileInfo;
final class SmartFileInfoTest extends \RectorPrefix20210503\PHPUnit\Framework\TestCase
{
    public function testInvalidPath() : void
    {
        $this->expectException(\RectorPrefix20210503\Symplify\SmartFileSystem\Exception\FileNotFoundException::class);
        new \Symplify\SmartFileSystem\SmartFileInfo('random');
    }
    public function testRelatives() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        $this->assertNotSame($smartFileInfo->getRelativePath(), $smartFileInfo->getRealPath());
        $normalizedRelativePath = $this->normalizePath($smartFileInfo->getRelativePath());
        $normalizedDir = $this->normalizePath(__DIR__);
        $this->assertStringEndsWith($normalizedRelativePath, $normalizedDir);
        $normalizedRelativePathname = $this->normalizePath($smartFileInfo->getRelativePathname());
        $normalizeFile = $this->normalizePath(__FILE__);
        $this->assertStringEndsWith($normalizedRelativePathname, $normalizeFile);
    }
    public function testRealPathWithoutSuffix() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
        $this->assertStringEndsWith('tests/SmartFileInfo/Source/AnotherFile', $smartFileInfo->getRealPathWithoutSuffix());
    }
    public function testRelativeToDir() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
        $relativePath = $smartFileInfo->getRelativeFilePathFromDirectory(__DIR__);
        $this->assertSame('Source/AnotherFile.txt', $relativePath);
    }
    public function testRelativeToDirException() : void
    {
        $this->expectException(\RectorPrefix20210503\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException::class);
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        $smartFileInfo->getRelativeFilePathFromDirectory('non-existing-path');
    }
    public function testDoesFnmatch() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
        // Test param
        $this->assertStringEndsWith($this->normalizePath('tests\\SmartFileInfo\\Source\\AnotherFile.txt'), $smartFileInfo->getRelativePathname());
        $this->assertStringEndsWith($this->normalizePath('tests/SmartFileInfo/Source/AnotherFile.txt'), $smartFileInfo->getRelativePathname());
        // Test function
        $this->assertTrue($smartFileInfo->doesFnmatch(__DIR__ . '/Source/AnotherFile.txt'));
        $this->assertTrue($smartFileInfo->doesFnmatch(__DIR__ . '\\Source\\AnotherFile.txt'));
    }
    /**
     * Normalizing required to allow running tests on windows.
     */
    private function normalizePath(string $path) : string
    {
        return \str_replace('\\', '/', $path);
    }
}
