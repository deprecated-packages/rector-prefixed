<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Tests\Rector\LNumber\AddLiteralSeparatorToNumberRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddLiteralSeparatorToNumberRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class => [\_PhpScopere8e811afab72\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::LIMIT_VALUE => 1000000]];
    }
}
