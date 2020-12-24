<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\EasyTesting\Tests\StaticFixtureSplitter;

use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
use _PhpScoper0a6b37af0871\Symplify\EasyTesting\StaticFixtureSplitter;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class StaticFixtureSplitterTest extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $fileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/simple_fixture.php.inc');
        $inputAndExpected = \_PhpScoper0a6b37af0871\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToInputAndExpected($fileInfo);
        $this->assertSame('a' . \PHP_EOL, $inputAndExpected->getInput());
        $this->assertSame('b' . \PHP_EOL, $inputAndExpected->getExpected());
    }
    public function testSplitFileInfoToLocalInputAndExpected() : void
    {
        $fileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/file_and_value.php.inc');
        $inputFileInfoAndExpected = \_PhpScoper0a6b37af0871\Symplify\EasyTesting\StaticFixtureSplitter::splitFileInfoToLocalInputAndExpected($fileInfo);
        $inputFileRealPath = $inputFileInfoAndExpected->getInputFileRealPath();
        $this->assertFileExists($inputFileRealPath);
        $this->assertSame(15025, $inputFileInfoAndExpected->getExpected());
    }
}
