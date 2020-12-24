<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php73\Tests\Rector\BinaryOp\IsCountableRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Php73\Rector\BinaryOp\IsCountableRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PolyfillRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureWithPolyfill');
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE - 1;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php73\Rector\BinaryOp\IsCountableRector::class;
    }
}
