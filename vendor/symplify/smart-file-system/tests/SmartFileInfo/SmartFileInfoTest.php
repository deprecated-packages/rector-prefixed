<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SmartFileSystem\Tests\SmartFileInfo;

use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\FileNotFoundException;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class SmartFileInfoTest extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    public function testInvalidPath() : void
    {
        $this->expectException(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\FileNotFoundException::class);
        new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo('random');
    }
    public function testRelatives() : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        $this->assertNotSame($smartFileInfo->getRelativePath(), $smartFileInfo->getRealPath());
        $this->assertStringEndsWith($this->normalizePath($smartFileInfo->getRelativePath()), $this->normalizePath(__DIR__));
        $this->assertStringEndsWith($this->normalizePath($smartFileInfo->getRelativePathname()), $this->normalizePath(__FILE__));
    }
    public function testRealPathWithoutSuffix() : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
        $this->assertStringEndsWith('tests/SmartFileInfo/Source/AnotherFile', $smartFileInfo->getRealPathWithoutSuffix());
    }
    public function testRelativeToDir() : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
        $this->assertSame('Source/AnotherFile.txt', $smartFileInfo->getRelativeFilePathFromDirectory(__DIR__));
    }
    public function testRelativeToDirException() : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        $this->expectException(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\Exception\DirectoryNotFoundException::class);
        $smartFileInfo->getRelativeFilePathFromDirectory('non-existing-path');
    }
    public function testDoesFnmatch() : void
    {
        $smartFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/AnotherFile.txt');
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
    private function normalizePath($path) : string
    {
        return \str_replace('\\', '/', $path);
    }
}
