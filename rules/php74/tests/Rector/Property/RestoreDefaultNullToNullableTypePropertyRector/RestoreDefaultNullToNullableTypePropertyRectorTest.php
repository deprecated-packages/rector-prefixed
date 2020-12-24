<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php74\Tests\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RestoreDefaultNullToNullableTypePropertyRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
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
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class;
    }
}
