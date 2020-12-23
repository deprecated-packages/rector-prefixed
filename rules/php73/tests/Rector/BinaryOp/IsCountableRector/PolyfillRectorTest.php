<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php73\Tests\Rector\BinaryOp\IsCountableRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a2ac50786fa\Rector\Php73\Rector\BinaryOp\IsCountableRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class PolyfillRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithPolyfill');
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE - 1;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Rector\Php73\Rector\BinaryOp\IsCountableRector::class;
    }
}
