<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\EasyTesting\Tests\StaticFixtureSplitter;

use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureSplitterTest extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $fileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/simple_fixture.php.inc');
        $inputAndExpected = \_PhpScopere8e811afab72\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToInputAndExpected($fileInfo);
        $this->assertSame('a' . \PHP_EOL, $inputAndExpected->getInput());
        $this->assertSame('b' . \PHP_EOL, $inputAndExpected->getExpected());
    }
    public function testSplitFileInfoToLocalInputAndExpected() : void
    {
        $fileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/file_and_value.php.inc');
        $inputFileInfoAndExpected = \_PhpScopere8e811afab72\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpected($fileInfo);
        $inputFileRealPath = $inputFileInfoAndExpected->getInputFileRealPath();
        $this->assertFileExists($inputFileRealPath);
        $this->assertSame(15025, $inputFileInfoAndExpected->getExpected());
    }
}
