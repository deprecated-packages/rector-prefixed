<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Tests\Rector\Class_\RenamePropertyToMatchTypeRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class Php74TestTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::class;
    }
}
